<?php

use App\Core\ErrorHandler;
use App\Core\Logger;
use App\Core\Router;
use Dotenv\Dotenv;
use Slim\App;

require '../vendor/autoload.php';

// Handle config files.
$dotenv = Dotenv::create(__DIR__);
$dotenv->load();

$config = [
    'settings' => [
        'displayErrorDetails' => getenv('DEBUG')
    ]
];

$app = new App($config);

// Handle logger.
// Takes in default logger name and location of logs.
$container = $app->getContainer();
try {
    $container['logger'] = Logger::initialize(
        'logger',
        getenv('LOG_FILE'),
        Monolog\Logger::DEBUG
    );
} catch (Exception $e) {
}

// Handle errors.
$container['errorHandler'] = static function ($container) {
    return new ErrorHandler($container);
};

// Handle router.
// Takes in array of routes files (from config/routes/).
$router = new Router(
    $app,
    [
        'common.yaml'
    ]
);
$router->createRoutes();
