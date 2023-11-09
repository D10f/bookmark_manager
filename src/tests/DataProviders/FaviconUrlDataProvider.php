<?php

namespace Tests\DataProviders;

class FaviconUrlDataProvider
{
    static public function validUrlCases()
    {
        return [
            [
                'targetDomain' => 'https://laravel.com',
                'linkMetaTags' => ['<link rel="icon" href="/logo.png" />'],
                'expected' => "https://laravel.com/logo.png"
            ],
            [
                'targetDomain' => 'https://laravel.com',
                'linkMetaTags' => ['<link rel="icon" href="/logo.svg" />'],
                'expected' => "https://laravel.com/logo.svg"
            ],
            [
                'targetDomain' => 'https://laravel.com',
                'linkMetaTags' => ['<link rel="icon" href="/path/to/favicon/logo.svg" />'],
                'expected' => "https://laravel.com/path/to/favicon/logo.svg"
            ],
            [
                'targetDomain' => 'https://laravel.com',
                'linkMetaTags' => ['<link rel="icon" href="https://cdn.cloudflare.com/favicon.png" />'],
                'expected' => "https://cdn.cloudflare.com/favicon.png"
            ],
            [
                'targetDomain' => 'https://www.laravel.com',
                'linkMetaTags' => ['<link rel="icon" href="/logo.svg" />'],
                'expected' => "https://www.laravel.com/logo.svg"
            ],
            [
                'targetDomain' => 'https://www.laravel.com.br',
                'linkMetaTags' => ['<link rel="icon" href="/logo.svg" />'],
                'expected' => "https://www.laravel.com.br/logo.svg"
            ],
            [
                'targetDomain' => 'https://laravel.com/path/to/some/page',
                'linkMetaTags' => ['<link rel="icon" href="/logo.svg" />'],
                'expected' => "https://laravel.com/logo.svg"
            ],
            [
                'targetDomain' => 'https://laravel.com',
                'linkMetaTags' => ['<link rel="icon" sizes="32x32" href="/logo-32.svg" />'],
                'expected' => "https://laravel.com/logo-32.svg"
            ],
            [
                'targetDomain' => 'https://laravel.com',
                'linkMetaTags' => ['<link rel="alternate icon" href="/logo.svg" />'],
                'expected' => "https://laravel.com/logo.svg"
            ],
            [
                'targetDomain' => 'https://laravel.com',
                'linkMetaTags' => ['<link rel="shortcut icon" href="/logo.svg" />'],
                'expected' => "https://laravel.com/logo.svg"
            ],
            [
                'targetDomain' => 'https://laravel.com',
                'linkMetaTags' => [
                    '<link rel="icon" href="/logo.svg" />',
                    '<link rel="alternate icon" href="/logo.jpg" />',
                    '<link rel="shortcut icon" href="/logo.png" />',
                ],
                'expected' => "https://laravel.com/logo.svg"
            ],
            [
                'targetDomain' => 'https://laravel.com',
                'linkMetaTags' => [
                    '<link rel="alternate icon" href="/logo.jpg" />',
                    '<link rel="shortcut icon" href="/logo.png" />',
                ],
                'expected' => "https://laravel.com/logo.png"
            ],
            [
                'targetDomain' => 'https://laravel.com',
                'linkMetaTags' => [
                    '<link rel="icon" sizes="32x32" href="/logo-32.svg" />',
                    '<link rel="icon" sizes="48x48" href="/logo-48.svg" />',
                    '<link rel="icon" sizes="64x64" href="/logo-64.svg" />',
                ],
                'expected' => "https://laravel.com/logo-64.svg"
            ],
            [
                'targetDomain' => 'https://laravel.com',
                'linkMetaTags' => [
                    '<link rel="icon" href="/logo.svg" />',
                    '<link rel="icon alternate" href="/logo-48.svg" />',
                ],
                'expected' => "https://laravel.com/logo.svg"
            ],
        ];
    }
}
