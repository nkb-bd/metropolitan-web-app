<?php
require_once 'WeatherFetcher.php';

$apiKey = '1853f3ff8f61e17719aacaab543ab279';
$city = $_GET['city'] ?? 'Dhaka';
$error = '';
$output = '';

  try {
        $fetcher = new WeatherFetcher($apiKey);
        $data = $fetcher->fetch($city);
        echo '<pre>';
        print_r($data);exit;
   
    } catch (Exception $e) {
        $error = "Error: " . htmlspecialchars($e->getMessage());
    }
?>

