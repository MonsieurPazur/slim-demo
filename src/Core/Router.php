<?php

/**
 * Class for loading and handling routes.
 */

namespace App\Core;

use Slim\App;

/**
 * Class Router
 *
 * @package App\Core
 */
class Router
{
    /**
     * @var App $app Slim application.
     */
    private $app;

    /**
     * @var array $files different routes grouped in files
     */
    private $files;

    /**
     * Router constructor.
     *
     * @param App $app
     * @param array $files
     */
    public function __construct(App $app, array $files)
    {
        $this->app = $app;
        $this->files = $files;
    }

    /**
     * Creates all necessary routes within app.
     */
    public function createRoutes(): void
    {
        foreach ($this->files as $file) {
            $routes = yaml_parse_file(getenv('ROOT_DIR') . '/config/routes/' . $file);
            foreach ($routes as $name => $route) {
                $callback = '\\App\\Controller\\' . $route['controller'] .'Controller:' . $route['action'];
                $this->app->map([$route['method']], $route['route'], $callback);
            }
        }
    }
}
