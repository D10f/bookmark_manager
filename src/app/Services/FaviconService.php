<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Process;
use App\Helpers\URL;
use DiDom\Document;
use Exception;

class FaviconService
{
    protected URL $url;
    protected bool $fileExists;

    public function __construct(string $url, protected string $storageDisk = 'local')
    {
        $this->url = new URL($url);
        $this->fileExists = $this->checkFaviconExists("public/favicons/");
        $this->storageDisk = $storageDisk;
    }

    /**
     *
     */
    public function checkFaviconExists(string $path)
    {
        // TODO: environment variable for favicon location, size and format
        return Storage::disk($this->storageDisk)->exists($path . $this->url->hostname . ".webp");
    }

    /**
     *
     */
    public function extractFaviconUrl()
    {
        if ($this->fileExists)
        {
            throw new Exception('Favicon already exists');
        };

        $response = Http::get($this->url->canonical);

        if (!$response->ok())
        {
            throw new Exception('Unable to reach domain.');
        }

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
                $faviconUrlPath = parse_url($hrefAttribute)['path'];
                break;
            };
        }

        return $this->url->canonical . $faviconUrlPath;
    }

    /**
     *
     */
    public function downloadFavicon()
    {
        if ($this->fileExists)
        {
            throw new Exception('Favicon already exists');
        };

        $response = Http::get($this->extractFaviconUrl());

        if (!$response->ok())
        {
            throw new Exception('Unable to reach domain.');
        }

        $process = Process::input($response->body())->start(
            'convert -background none - -resize 32x32 -format webp -'
        );

        Storage::disk($this->storageDisk)->put("public/favicons/", $process->output());
    }
}
