<?php

namespace App\Listeners;

use App\Events\BookmarkProcessed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Process;
use DiDom\Document;

class FetchBookmarkFavicon
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BookmarkProcessed $event): void
    {
        $url = $event->bookmark->url;
        $this->downloadFavicon($url);
    }

    /**
     * Given a URL it extracts the domain name portion and returns it.
     */
    private function extractDomainName(string $url): array|string|null
    {
        return preg_replace('/^(?:https?:\/\/)?(?:[^@\n]+@)?(?:www\.)?([^:\/\n]+)/', '$1', $url);
    }

    /**
     * Given a valid URL it produces a canonical representation using the domain
     * name only, and HTTPS for the protocol.
     */
    private function makeCanonicalUrl(string $url): string
    {
        $domainName = $this->extractDomainName($url);
        return "https://$domainName";
    }

    /**
     * Parses the HTML document for the main domain page and attempts to obtain
     * the URL used to download the favicon. If not found, for example when the
     * favicon is not available until JS has loaded, it defaults to /favicon.ico
     */
    private function extractFaviconUrl(string $url): string
    {
        $canonicalUrl = $this->makeCanonicalUrl($url);
        $html = Http::get($canonicalUrl)->body();
        $doc = new Document($html);
        $tag = null;

        $targetAttributes = [
            'link[rel=icon]',
            'link[rel=shortcut icon]',
            'link[rel=alternate icon]'
        ];

        foreach ($targetAttributes as $attribute)
        {
            $tag = $doc->first($attribute);

            if ($tag)
            {
                $url = $tag->getAttribute('href');
                return str_starts_with($url, 'http') ? $url : "$canonicalUrl/$url";
            };
        }

        return "$canonicalUrl/favicon.ico";
    }

    /**
     * Determines whether the favicon has already been downloaded or not.
     */
    private function alreadyOnDisk(string $url): bool
    {
        return Storage::has("public/favicons/$url.webp");
    }

    /**
     * Spawns a separate process to convert the image through ImageMagick.
     */
    private function convertImage(string $input, array $options = [])
    {
        $cmd = "convert";
        foreach ($options as $key => $value)
        {
            $cmd = "$cmd -$key $value ";
        }
        $cmd = "$cmd $input " . preg_replace('/tmp$/', 'webp', $input);

        Process::path(storage_path('app/public/favicons'))->start($cmd);
    }

    /**
     * Public controller function that downloads a favicon if it's not already
     * present in the default Storage disk.
     */
    private function downloadFavicon(string $url)
    {
        $domainName = $this->extractDomainName($url);

        if ($this->alreadyOnDisk($domainName)) return;

        $faviconUrl = $this->extractFaviconUrl($url);

        $response = Http::get($faviconUrl);
        Storage::put("public/favicons/$domainName.webp", $response->body());

        // $faviconPath = "storage/app/public/favicons/$domainName.tmp";
        $this->convertImage("$domainName.webp", [
            'background' => 'none',
            'format' => 'webp',
            'resize' => '32x32'
        ]);
    }
}
