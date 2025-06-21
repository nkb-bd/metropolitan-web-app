<?php
require __DIR__ . '/vendor/autoload.php';

use App\WeatherFetcher;
use App\WeatherFormatter;
use App\LoggerFactory;
use GuzzleHttp\Client;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiKey = $_ENV['WEATHERSTACK_API_KEY'] ?? '';
echo "API Key: $apiKey\n";
$city = $argv[1] ?? 'New York';
$client = new Client(['base_uri' => 'http://api.weatherstack.com/']);
$logger = LoggerFactory::create();

// Print the full request URL for debugging
$requestUrl = "http://api.weatherstack.com/current?access_key=$apiKey&query=$city";
echo "Request URL: $requestUrl\n";

try {
    // Update fetcher to use new endpoint and parameters
    $response = $client->request('GET', 'current', [
        'query' => [
            'access_key' => $apiKey,
            'query' => $city
        ]
    ]);
    $data = json_decode($response->getBody(), true);
    echo WeatherFormatter::format($data);
    $logger->info("Fetched weather for $city");
} catch (Exception $e) {
    $logger->error($e->getMessage());
    echo "Error: " . $e->getMessage() . "\n";
}
