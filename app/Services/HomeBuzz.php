<?php

namespace App\Services;

use GuzzleHttp\Client;

class HomeBuzz
{
    private $base_url = 'http://homebuzz.me';

    /**
     * @var Client
     */
    public $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->base_url
        ]);
    }
}
