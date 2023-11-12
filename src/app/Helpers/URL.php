<?php

namespace App\Helpers;

class URL
{
    public $scheme;
    public $hostname;
    public $path;
    public $canonical;

    public function __construct(string $url)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL))
        {
            throw new \InvalidArgumentException('Invalid URL provided.');
        }

        $parsed_url = parse_url($url);
        $this->scheme = $parsed_url['scheme'];
        $this->hostname = $parsed_url['host'];
        $this->path = $parsed_url['path'] ?? '';
        $this->canonical = $parsed_url['scheme'] . '://' . $parsed_url['host'];
    }
}
