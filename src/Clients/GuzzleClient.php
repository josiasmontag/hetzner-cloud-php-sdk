<?php

namespace LKDev\HetznerCloud\Clients;

use GuzzleHttp\Client;
use LKDev\HetznerCloud\HetznerAPIClient;

class GuzzleClient
{
    protected Client $client;

    /**
     * @param  HetznerAPIClient  $client
     * @param  array  $additionalGuzzleConfig
     */
    public function __construct(HetznerAPIClient $client, $additionalGuzzleConfig = [])
    {
        $guzzleConfig = array_merge([
            'base_uri' => $client->getBaseUrl(),
            'headers' => [
                'Authorization' => 'Bearer '.$client->getApiToken(),
                'Content-Type' => 'application/json',
                'User-Agent' => ((strlen($client->getUserAgent()) > 0) ? $client->getUserAgent().' ' : '').'hcloud-php/'.HetznerAPIClient::VERSION,
            ],
        ], $additionalGuzzleConfig);
        $this->client = new Client($guzzleConfig);
    }

    public function __call($name, $arguments)
    {
        return $this->client->$name(...$arguments);
    }
}
