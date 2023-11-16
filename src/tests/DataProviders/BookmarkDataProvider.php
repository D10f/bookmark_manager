<?php

namespace Tests\DataProviders;

class BookmarkDataProvider
{
    public static function validationCases()
    {
        return array_merge(
            BookmarkDataProvider::validCases(),
            BookmarkDataProvider::invalidCases()
        );
    }

    public static function validCases()
    {
        $maxUrlLength = env('APP_MAX_URL_LENGTH', 2048);

        return [
            ['name', 'this is a valid name', true],
            ['name', 'a', true],
            ['name', str_pad('a', 255, '_'), true],
            ['url', 'http://validurl.com', true],
            ['url', 'https://validurl.com', true],
            ['url', 'about:config', true],
            ['url', 'also a valid url', true],
            ['url', 'a', true],
            ['url', str_pad('a', $maxUrlLength, '_'), true],
            ['category', 'good category', true],
            ['category', 'alien vs pokemon', true],
            ['category', 'a', true],
            ['category', str_pad('a', 255, '_'), true],
        ];
    }

    public static function invalidCases()
    {
        $maxUrlLength = env('APP_MAX_URL_LENGTH', 2048);

        return [
            ['name', '', false, 'The name is required.'],
            ['name', str_pad('a', 256, '_'), false, 'The name cannot exceed 255 characters.'],
            ['url', '', false, 'The url is required.'],
            ['url', str_pad('a', $maxUrlLength + 1, '_'), false,   'The url cannot exceed 2048 characters.'],
            ['category', '', false, 'The category is required.'],
            ['category', str_pad('a', 256, '_'), false, 'The category cannot exceed 255 characters.'],
        ];
    }
}
