<?php

namespace Tests\Unit;

use App\Services\FaviconService;
use Exception;
use Illuminate\Process\PendingProcess;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FaviconServiceTest extends TestCase
{
    public function test_correctly_extracts_favicon()
    {
        Http::fakeSequence()
            ->push('<html><head><link rel="icon" href="/logo.png" /></head><body></body></html>')
            ->push('<html><head><link rel="icon" /></head><body></body></html>')
            ->push('<html><head><link rel="icon" sizes="32x32" href="/logo-32.png" /></head><body></body></html>')
            ->push('<html><head><link rel="icon" href="https://laravel.com/logo-32.svg" /></head><body></body></html>')
            ->push('<html><head><link rel="icon" href="http://laravel.com/logo-32.svg" /></head><body></body></html>')
            ->whenEmpty(Http::response('Not Found', 404));

        $actual = (new FaviconService('https://laravel.com'))->extractFaviconUrl();
        $this->assertSame('https://laravel.com/logo.png', $actual);

        $actual = (new FaviconService('https://laravel.com'))->extractFaviconUrl();
        $this->assertSame('https://laravel.com/favicon.ico', $actual);

        $actual = (new FaviconService('https://laravel.com'))->extractFaviconUrl();
        $this->assertSame('https://laravel.com/logo-32.png', $actual);

        $actual = (new FaviconService('https://laravel.com'))->extractFaviconUrl();
        $this->assertSame('https://laravel.com/logo-32.svg', $actual);

        $actual = (new FaviconService('http://laravel.com'))->extractFaviconUrl();
        $this->assertSame('http://laravel.com/logo-32.svg', $actual);
    }

    public function test_fails_with_random_string()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid URL provided.');
        new FaviconService('something totally invalid');
    }

    public function test_fails_with_schemeless_url()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid URL provided.');
        new FaviconService('laravel.com');
    }

    public function test_fails_with_non_200_responses()
    {
        Http::fake([
            '*' => Http::response('Not found', 404)
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Unable to reach domain.');
        (new FaviconService('http://laravel.com'))->extractFaviconUrl();
    }

    public function test_fails_when_favicon_already_exists()
    {
        Storage::fake('favicon')->put('public/favicons/laravel.com.webp', 'hello world');
        Http::spy();

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Favicon already exists');
        (new FaviconService('http://laravel.com', 'favicon'))->extractFaviconUrl();
    }

    public function test_successfully_writes_favicon_to_disk()
    {
        Storage::fake('favicon');

        Http::fake([
            '*' => Http::response('hello world', 200)
        ]);

        Process::fake();

        (new FaviconService('http://laravel.com', 'favicon'))->downloadFavicon();

        Process::assertRan(function (PendingProcess $process) {
            return $process->input === 'hello world';
        });
    }
}
