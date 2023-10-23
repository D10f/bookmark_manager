<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Intervention\Image\ImageManager;
use DiDom\Document;

class FaviconController extends Controller
{

    public function fetch(string $url)
    {
        $html = Http::get(urlencode($url));
        $document = new Document($html->body());
        $faviconMeta = $document->first('link[rel=icon]');

        if ($faviconMeta === null)
        {
            $faviconMeta = $document->first('link[rel=shortcut icon]');
        }

        if ($faviconMeta === null)
        {
            $faviconMeta = $document->first('link[rel=alternate icon]');
        }

        $faviconUrl = $faviconMeta->getAttribute('href');

        $response = Http::get(
            str_starts_with($faviconUrl, 'http') ? $faviconUrl : 'http://' . $url . $faviconUrl
        );

        $manager = new ImageManager(['driver' => 'imagick']);

        $faviconRaw = $response->body();

        if (str_contains($faviconUrl, '.ico'))
        {
            return response($faviconRaw);
        } else
        {
            return $manager->make($faviconRaw)->resize(32,32)->encode('ico');
        }

        // return response()->streamDownload(function() use ($faviconImg) {
        //     echo $faviconImg;
        // }, 'favicon', ['Content-Type' => 'application/octet-stream']);
    }
}
