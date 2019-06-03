<?php

/**
 * Custom error handler, logs errors and handles error responses.
 */

namespace App\Core;

use Exception;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class ErrorHandler
 *
 * @package App\Core
 */
class ErrorHandler
{
    /**
     * @var LoggerInterface $logger used to log error
     */
    private $logger;

    /**
     * ErrorHandler constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->logger = $container->get('logger');
    }

    /**
     * Logs error and returns appropriate response.
     *
     * @param Request $request
     * @param Response $response
     * @param Exception $exception
     *
     * @return ResponseInterface
     */
    public function __invoke(Request $request, Response $response, Exception $exception): ResponseInterface
    {
        $this->logger->critical($exception->getMessage());
        return $response
            ->withStatus(500)
            ->withHeader('Content-Type', 'text/html')
            ->write('Something went wrong!');
    }
}
