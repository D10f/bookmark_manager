<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
// use Intervention\Image\Facades\Image;

class FaviconController extends Controller
{
    //
    public function fetch(string $url)
    {
        $response = Http::get('https://' . $url);
        $faviconUrls = array();

        $match = preg_match(
            '/<link rel="(?:shortcut )?icon"[^>]*href="([^>]*)"/',
            $response->body(),
            $faviconUrls,
        );

        if ($match === false)
        {
            return response()->status(404);
        }


        $isBinaryFormat = !str_contains($faviconUrls[1], 'svg');

        return response()->streamDownload(function () use ($url, $faviconUrls) {
            echo Http::get('https://' . $url . $faviconUrls[1]);
        }, 'favicon', ['Content-Type' => $isBinaryFormat ? 'application/octet-stream' : 'text/plain']);
    }
}
