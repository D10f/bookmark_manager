<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use DiDom\Document;
use Illuminate\Http\File;

class FaviconController extends Controller
{

    public function fetch(string $url)
    {
        $html = Http::get(urlencode($url));
        $document = new Document($html->body());
        $faviconMeta = $document->first('link[rel=icon]');
        $domain = preg_replace('/(?:https?:\/\/)?(\w+)/', '$1', $url);

        if ($faviconMeta === null)
        {
            $faviconMeta = $document->first('link[rel=shortcut icon]');
        }

        if ($faviconMeta === null)
        {
            $faviconMeta = $document->first('link[rel=alternate icon]');
        }

        if ($faviconMeta === null)
        {
            // one last attempt to route /favicon.ico
            // $response = Http::get(
            //     str_starts_with($url, 'http') ? $url : 'http://' . $url . '/favicon.ico'
            // );
            $response = Http::get(urlencode($url . '/favicon.ico'));

            if ($response->status() === 200)
            {
                Storage::put('app/public/favicons/' . $domain . '/' . 'favicon.ico', $response->body());
                return $response->body();
            }

            return response('Unable to locate favicon.', 404);
        }

        $faviconUrl = $faviconMeta->getAttribute('href');

        $response = Http::get(
            str_starts_with($faviconUrl, 'http') ? $faviconUrl : 'http://' . $url . $faviconUrl
        );

        $manager = new ImageManager(['driver' => 'imagick']);

        $faviconRaw = $response->body();

        if (!str_contains($faviconUrl, '.ico'))
        {
            $faviconRaw = $manager->make($faviconRaw)->resize(32,32)->encode('ico');
        }

        Storage::put('app/public/favicons/' . $domain . '/' . 'favicon.ico', $faviconRaw);

        return response($faviconRaw);
    }
}
