<?php

use App\Core\Logger;
use App\Core\Router;
use App\Handler\ErrorHandler;
use App\Handler\NotAllowedHandler;
use App\Handler\NotFoundHandler;
use Dotenv\Dotenv;
use Slim\App;
use Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware;

require '../vendor/autoload.php';

// Handle config files.
$dotenv = Dotenv::create(__DIR__);
$dotenv->load();

$app = new App(require 'settings.php');

// Handle logger.
$container = $app->getContainer();
try {
    $container['logger'] = Logger::initialize(
        'logger',
        getenv('LOG_FILE'),
        Monolog\Logger::DEBUG
    );
} catch (Exception $e) {
}

// Handle middleware.
//
// Load whoops only in debug mode.
// In other cases standard ErrorHandler should be used.
//
// Note: whoops won't handle anything if debug=0 but we don't want
// to load it at all, when debug is disabled.
if ((bool)getenv('DEBUG')) {
    $app->add(new WhoopsMiddleware($app));
}

// Handle errors.
// 500
$container['errorHandler'] = static function ($container) {
    return new ErrorHandler($container);
};

// 405
$container['notAllowedHandler'] = static function ($container) {
    return new NotAllowedHandler($container);
};

// 404
$container['notFoundHandler'] = static function ($container) {
    return new NotFoundHandler($container);
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
