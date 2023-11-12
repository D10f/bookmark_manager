<?php

namespace Tests\Unit;

use App\Services\FaviconService;
use Exception;
use Illuminate\Process\PendingProcess;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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
        Storage::fake('favicon');
        $spy = Http::fake([
            '*' => Http::response('<html><head>' . implode(' ', $linkMetaTags) . '</head><body></body></html>', 200)
        ]);

        $service = new FaviconService($targetDomain, 'favicon');
        $result = $service->getDownloadUrl();
        $this->assertSame($expected, $result);

        // Assert response is memoized
        $result = $service->getDownloadUrl();
        $spy->assertSentCount(1);
    }

    public function test_correctly_defaults_to_favicon_ico_when_no_link_tags()
    {
        Storage::fake('favicon');
        Http::fake([
            '*' => Http::response('<html><head></head><body></body></html>', 200)
        ]);

        $service = new FaviconService('https://laravel.com', 'favicon');
        $result = $service->getDownloadUrl();
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
        Storage::fake('favicon');
        Http::fake([
            '*' => Http::response('Not found', 404)
        ]);

        $this->expectExceptionCode(404);
        $service = new FaviconService('http://laravel.com', 'favicon');
        $service->getDownloadUrl();
    }

    public function do_nothing_when_favicon_already_exists()
    {
        Storage::fake('favicon')->put('favicons/laravel.com.webp', 'hello world');
        $httpSpy = Http::spy();

        $service = new FaviconService('http://laravel.com', 'favicon');
        $service->download();

        $httpSpy->shouldNotReceive('get');
    }

    /**
     * @dataProvider Tests\DataProviders\FaviconUrlDataProvider::extensionsProcessedAsFiles
     */
    public function test_successfully_spawns_process_as_files(string $mimeType)
    {
        Storage::fake('favicon');

        $htmlRes = '<html><head><link rel="icon" href="/logo.' . $mimeType . '" /></head><body></body></html>';

        Http::fakeSequence()
            ->push($htmlRes, 200)
            ->push('Hello, world', 200)
            ->whenEmpty(Http::response());

        Process::fake();

        $service = new FaviconService('http://laravel.com', 'favicon');
        $service->download();

        Process::assertRan(function (PendingProcess $process) {
            return $process->input === NULL &&
                   str_contains($process->command, 'laravel.com.webp');
        });
    }

    /**
     * @dataProvider Tests\DataProviders\FaviconUrlDataProvider::extensionsProcessedAsStream
     */
    public function test_successfully_spawns_process_as_stream(string $mimeType)
    {
        $storageFake = Storage::fake('favicon');

        $htmlRes = '<html><head><link rel="icon" href="/logo.' . $mimeType . '" /></head><body></body></html>';
        $faviconData = 'Hello, world';

        Http::fakeSequence()
            ->push($htmlRes, 200)
            ->push($faviconData, 200)
            ->whenEmpty(Http::response());

        Process::fake();

        $this->assertFalse($storageFake->exists('/favicons/laravel.com.webp'));

        $service = new FaviconService('http://laravel.com', 'favicon');
        $service->download();

        Process::assertRan(fn (PendingProcess $process) =>
            $process->input === $faviconData
        );

        $this->assertTrue($storageFake->exists('/favicons/laravel.com.webp'));
    }
}
