<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Process;
use Illuminate\Contracts\Filesystem\Filesystem;
use Intervention\Image\Facades\Image;
use App\Helpers\URL;
use DiDom\Document;

class FaviconService
{
    /**
     * URL helper wrapper that provides access to the different components of the URL.
     */
    protected URL $url;

    /**
     * Default location to store favicons.
     */
    protected Filesystem $disk;

    /**
     * Checks if a favicon already exists for the given domain.
     */
    protected ?bool $fileExists = null;

    /**
     * The favicon url for the given domain.
     */
    protected ?string $downloadUrl = null;

    /**
     * The image mime type based on the url provided.
     */
    protected ?string $mimeType = null;

    /**
     * Constructs the favicon service around the given domain name.
     */
    public function __construct(string $url, string $storageDisk = 'public')
    {
        $this->url = new URL($url);
        $this->disk = Storage::disk($storageDisk);
    }

    /**
     *
     */
    public function getFileExists()
    {
        if (isset($this->fileExists)) {
            return $this->fileExists;
        }

        $this->fileExists = $this->disk->exists('favicons/' . $this->url->hostname . ".webp");
        return $this->fileExists;
    }

    /**
     *
     */
    public function getMimeType()
    {
        if (isset($this->mimeType))
        {
            return $this->mimeType;
        }

        $faviconPath = (new URL($this->getDownloadUrl()))->path;
        preg_match('/.*\.([a-zA-Z]+)$/', $faviconPath, $matches);

        $this->mimeType = $matches[1];
        return $this->mimeType;
    }

    /**
     *
     */
    public function getDownloadUrl()
    {
        if (isset($this->downloadUrl))
        {
            return $this->downloadUrl;
        }

        $response = Http::get($this->url->canonical)->throw();

        $html = new Document($response->body());

        $faviconUrlPath = '/favicon.ico';

        $targetAttributes = [
            'link[rel="icon"][sizes="64x64"]',
            'link[rel="icon"][sizes="60x60"]',
            'link[rel="icon"][sizes="48x48"]',
            'link[rel="icon"][sizes="32x32"]',
            'link[rel="icon"]',
            'link[rel="shortcut icon"][sizes="64x64"]',
            'link[rel="shortcut icon"][sizes="60x60"]',
            'link[rel="shortcut icon"][sizes="48x48"]',
            'link[rel="shortcut icon"][sizes="32x32"]',
            'link[rel="shortcut icon"]',
            'link[rel="alternate icon"][sizes="64x64"]',
            'link[rel="alternate icon"][sizes="60x60"]',
            'link[rel="alternate icon"][sizes="48x48"]',
            'link[rel="alternate icon"][sizes="32x32"]',
            'link[rel="alternate icon"]'
        ];

        foreach ($targetAttributes as $attribute)
        {
            if ($tag = $html->first($attribute))
            {
                $hrefAttribute = $tag->getAttribute('href', '/favicon.ico');
                $parsedHref = parse_url($hrefAttribute);

                if (str_starts_with($hrefAttribute, 'http'))
                {
                    $this->downloadUrl = $hrefAttribute;
                    return $hrefAttribute;
                }

                $faviconUrlPath = $parsedHref['path'];
                break;
            };
        }

        $this->downloadUrl = $this->url->canonical . $faviconUrlPath;
        return $this->downloadUrl;
    }

    /**
     *
     */
    protected function _processImageAsStream(string $data)
    {
        $process = Process::input($data)->run(
            "convert -background none -" . "[1]" . " -resize 32x32 -format webp -"
        )->throw();

        $this->disk->put(
            "favicons/" . $this->url->hostname . ".webp",
            $process->output()
        );
    }

    /**
     *
     */
    protected function _processImageAsFile(string $data)
    {
        $this->disk->put('favicons/tmp.' . $this->getMimeType(), $data);
        $temp = 'tmp.' . $this->getMimeType();
        $output = $this->url->hostname . ".webp";

        try
        {
            // Some websites *cough* Discord, Stackoverflow *cough* have decided
            // that using animated images for their favicons is a good idea. To
            // work around that, extract only one frame from the image source.
            // But, of course, not the first one at index zero because that's
            // usually the one with the lowest quality...
            Process::path($this->disk->path('favicons/'))
                ->run("convert -background none $temp" . "[1]" . " -resize 32x32 -format webp $output")
                ->throw();
        }
        catch (\Illuminate\Process\Exceptions\ProcessFailedException $e)
        {
            Log::warning($e->getMessage());
        }
        finally
        {
            $this->disk->delete('favicons/' . $temp);
        }
    }

    /**
     *
     */
    public function download()
    {
        if ($this->getFileExists())
        {
            Log::info('Favicon for ' . $this->url->canonical . ' already exists.');
            return;
        }

        try {
            $response = Http::get($this->getDownloadUrl())->throw();

            match ($this->getMimeType())
            {
                'png','jpg','jpeg','webp' => $this->_processImageAsStream($response->body()),
                'svg','ico' => $this->_processImageAsFile($response->body()),
                'default' => throw new \Exception('Unexpected file type.'),
            };
        }
        catch (\Illuminate\Http\Client\RequestException)
        {
            Log::error('Unable to download favicon for ' . $this->url->canonical);
        }
        catch (\Exception $e)
        {
            Log::info($e->getMessage() . '(' . $e->getFile() . ' - ' . $e->getLine());
        }
    }
}
