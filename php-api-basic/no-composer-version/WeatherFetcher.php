<?php
class WeatherFetcher
{
    private $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function fetch($city)
    {
        $url = "http://api.weatherstack.com/current?query=" . urlencode($city) . "&access_key=" . $this->apiKey;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $json = curl_exec($ch);
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            throw new Exception("cURL error: $error_msg");
        }
        curl_close($ch);
        if ($json === false) {
            throw new Exception("Failed to fetch weather data.");
        }
        return json_decode($json, true);
    }
}
