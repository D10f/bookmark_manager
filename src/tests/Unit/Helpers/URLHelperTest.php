<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Helpers\URL;

class URLHelperTest extends TestCase
{
    public function test_accepts_valid_urls()
    {
        $this->assertInstanceOf(
            URL::class,
            new URL('https://laravel.com')
        );

        $this->assertInstanceOf(
            URL::class,
            new URL('https://laravel.com/app')
        );

        $this->assertInstanceOf(
            URL::class,
            new URL('https://www.laravel.com/app')
        );

        $this->assertInstanceOf(
            URL::class,
            new URL('https://laravel.com.br')
        );

        $this->assertInstanceOf(
            URL::class,
            new URL('https://invidious.snopyta.org')
        );
    }

    public function test_correctly_retrieves_url_parts()
    {
        $urlService = new URL('https://laravel.com');
        $this->assertEquals('https', $urlService->scheme);
        $this->assertEquals('laravel.com', $urlService->hostname);
        $this->assertEquals('https://laravel.com', $urlService->canonical);
    }

    public function test_correctly_retrieves_full_domain()
    {
        $this->assertEquals('www.laravel.com', (new URL('https://www.laravel.com/app'))->hostname);
        $this->assertEquals('docs.laravel.com', (new URL('https://docs.laravel.com'))->hostname);
        $this->assertEquals('docs.laravel.com.br', (new URL('https://docs.laravel.com.br'))->hostname);
    }

    public function test_ignore_path_from_url()
    {
        $urlService = new URL('https://laravel.com/app');
        $this->assertEquals('https', $urlService->scheme);
        $this->assertEquals('laravel.com', $urlService->hostname);
        $this->assertEquals('https://laravel.com', $urlService->canonical);
    }

    public function test_fails_when_scheme_is_missing()
    {
        $this->expectExceptionMessage('Invalid URL provided.');
        new URL('laravel.com');
    }

    public function test_fails_when_domain_is_missing()
    {
        $this->expectExceptionMessage('Invalid URL provided.');
        new URL('http://');
    }

    public function test_fails_when_random_string_provided()
    {
        $this->expectExceptionMessage('Invalid URL provided.');
        new URL('laravel');
    }

    public function test_fails_when_browser_specific_urls_provided()
    {
        $this->expectExceptionMessage('Invalid URL provided.');
        new URL('about:config');
    }
}
