<?php

namespace App\Jobs;

use App\Helpers\URL;
use App\Models\Bookmark;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Services\FaviconService;
use Exception;

class DownloadFavicon implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $bookmark;

    public function __construct(Bookmark $bookmark)
    {
        $this->bookmark = $bookmark;
        Log::info('DownloadFavicon job dispatched.' . PHP_EOL);
    }

    public function handle(): void
    {
        $url = new URL($this->bookmark['url']);
        $service = new FaviconService($url->canonical);
        $service->download();
    }

    public function failed(Exception $e)
    {
        Log::info($e->getMessage());
    }
}
