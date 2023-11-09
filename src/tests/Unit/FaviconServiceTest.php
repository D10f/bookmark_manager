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

    /**
     * @dataProvider Tests\DataProviders\FaviconUrlDataProvider::validUrlCases
     */
    public function test_correctly_extracts_favicon_url_when_available
    (
        string $targetDomain,
        array $linkMetaTags,
        string $expected
    )
    {
        Http::fake([
            '*' => Http::response('<html><head>' . implode(' ', $linkMetaTags) . '</head><body></body></html>', 200)
        ]);

        $service = new FaviconService($targetDomain);
        $result = $service->extractFaviconUrl();
        $this->assertSame($expected, $result);
    }

    public function test_correctly_defaults_to_favicon_ico_when_no_link_tags()
    {
        Http::fake([
            '*' => Http::response('<html><head></head><body></body></html>', 200)
        ]);

        $result = (new FaviconService('https://laravel.com'))->extractFaviconUrl();
        $this->assertSame('https://laravel.com/favicon.ico', $result);
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
