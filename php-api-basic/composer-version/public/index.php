<?php
require __DIR__ . '/../vendor/autoload.php';

use App\WeatherFormatter;
use App\LoggerFactory;
use GuzzleHttp\Client;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$apiKey = $_ENV['WEATHERSTACK_API_KEY'] ?? '';
$city = $_GET['city'] ?? 'New York';
$client = new Client(['base_uri' => 'http://api.weatherstack.com/']);
$logger = LoggerFactory::create();

$error = '';
$output = '';

if ($city) {
    try {
        $response = $client->request('GET', 'current', [
            'query' => [
                'access_key' => $apiKey,
                'query' => $city
            ]
        ]);
        $data = json_decode($response->getBody(), true);
        if (isset($data['current']) && isset($data['location'])) {
            $output = '<p><strong>Feels Like:</strong> ' . htmlspecialchars($data['current']['feelslike']) . '°C</p>';
            
        } else {
            $output = 'No weather data found.';
        }
        $logger->info("Fetched weather for $city");
    } catch (Exception $e) {
        $logger->error($e->getMessage());
        $error = "Error: " . htmlspecialchars($e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Weather App (Composer Version)</title>
</head>
<body>
    <h1>PHP Weather App (Composer Version)</h1>
    <form method="get">
        <label for="city">City:</label>
        <input type="text" id="city" name="city" value="<?= htmlspecialchars($city) ?>">
        <button type="submit">Get Weather</button>
    </form>
    <div style="margin-top:20px;">
        <?php if ($error): ?>
            <div style="color:red;"> <?= $error ?> </div>
        <?php elseif ($output): ?>
            <div><?= $output ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
