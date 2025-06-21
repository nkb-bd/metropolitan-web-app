<?php
namespace App;

class WeatherFormatter
{
    public static function format(array $data): string
    {
        return "🌤 Weather for {$data['name']}:\n" .
               "Temperature: {$data['main']['temp']}°C\n" .
               "Condition: {$data['weather'][0]['description']}\n";
    }
}
