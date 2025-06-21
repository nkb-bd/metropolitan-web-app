<?php
namespace App;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class LoggerFactory
{
    public static function create(): Logger
    {
        $logger = new Logger('weather');
        $logger->pushHandler(new StreamHandler(__DIR__ . '/../../weather.log', Logger::DEBUG));
        return $logger;
    }
}
