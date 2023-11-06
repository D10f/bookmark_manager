<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\URLService;

class UrlServiceTest extends TestCase
{
    public function test_accepts_valid_urls()
    {
        $this->assertInstanceOf(
            URLService::class,
            new URLService('https://laravel.com')
        );

        $this->assertInstanceOf(
            URLService::class,
            new URLService('https://laravel.com/app')
        );

        $this->assertInstanceOf(
            URLService::class,
            new URLService('https://www.laravel.com/app')
        );

        $this->assertInstanceOf(
            URLService::class,
            new URLService('https://laravel.com.br')
        );

        $this->assertInstanceOf(
            URLService::class,
            new URLService('https://invidious.snopyta.org')
        );
    }

    public function test_correctly_retrieves_url_parts()
    {
        $urlService = new URLService('https://laravel.com');
        $this->assertEquals('https', $urlService->scheme);
        $this->assertEquals('laravel.com', $urlService->hostname);
        $this->assertEquals('https://laravel.com', $urlService->canonical);
    }

    public function test_correctly_retrieves_full_domain()
    {
        $this->assertEquals('www.laravel.com', (new URLService('https://www.laravel.com/app'))->hostname);
        $this->assertEquals('docs.laravel.com', (new URLService('https://docs.laravel.com'))->hostname);
        $this->assertEquals('docs.laravel.com.br', (new URLService('https://docs.laravel.com.br'))->hostname);
    }

    public function test_ignore_path_from_url()
    {
        $urlService = new URLService('https://laravel.com/app');
        $this->assertEquals('https', $urlService->scheme);
        $this->assertEquals('laravel.com', $urlService->hostname);
        $this->assertEquals('https://laravel.com', $urlService->canonical);
    }

    public function test_fails_when_scheme_is_missing()
    {
        $this->expectExceptionMessage('Invalid URL provided.');
        new URLService('laravel.com');
    }

    public function test_fails_when_domain_is_missing()
    {
        $this->expectExceptionMessage('Invalid URL provided.');
        new URLService('http://');
    }

    public function test_fails_when_random_string_provided()
    {
        $this->expectExceptionMessage('Invalid URL provided.');
        new URLService('laravel');
    }

    public function test_fails_when_browser_specific_urls_provided()
    {
        $this->expectExceptionMessage('Invalid URL provided.');
        new URLService('about:config');
    }
}
