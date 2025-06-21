<?php

namespace App;

use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

class WeatherFetcher
{
    private string $apiKey;
    private Client $client;
    private LoggerInterface $logger;

    public function __construct(string $apiKey, Client $client, LoggerInterface $logger)
    {
        $this->apiKey = $apiKey;
        $this->client = $client;
        $this->logger = $logger;
    }

    public function fetch(string $city): array
    {
        $this->logger->info("Fetching weather for $city");
        $response = $this->client->get("weather", [
            'query' => [
                'q' => $city,
                'appid' => $this->apiKey,
                'units' => 'metric'
            ]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }
}
