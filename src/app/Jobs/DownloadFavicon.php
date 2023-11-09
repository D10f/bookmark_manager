<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Helpers\URL;
use App\Services\FaviconService;
use Exception;

class DownloadFavicon implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $domain;

    /**
     * Initializes the job
     */
    public function __construct(URL $url)
    {
        $this->domain = $url->canonical;
    }

    /**
     * Runs the job
     */
    public function handle(): void
    {
        $service = new FaviconService($this->domain);
        $service->downloadFavicon();
    }

    /**
     *
     */
    public function uniqueId()
    {
        return $this->domain;
    }

    /**
     *
     */
    public function failed(Exception $e)
    {
        Log::info($e->getMessage());
    }
}
