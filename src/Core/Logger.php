<?php

/**
 * Wrapper class for Monolog Logger. Handles configuration within framework.
 */

namespace App\Core;

use Exception;
use Monolog\Handler\StreamHandler;
use Monolog\Logger as MonologLogger;

/**
 * Class Logger
 *
 * @package App\Core
 */
class Logger extends MonologLogger
{
    /**
     * Initializes Monolog Logger.
     *
     * @param string $name name of this logger
     * @param string $path where to log to
     * @param int $level what sort of messages should be logged
     *
     * @return Logger instance of Logger to put in application container
     *
     * @throws Exception
     */
    public static function initialize(string $name, string $path, int $level): Logger
    {
        $logger = new self($name);
        $fileHandler = new StreamHandler($path, $level);
        $logger->pushHandler($fileHandler);
        return $logger;
    }
}
