<?php

/**
 * Custom error handler, logs errors and handles error responses.
 */

namespace App\Core\Handler;

use App\Handler\CustomHandler;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class ErrorHandler
 *
 * @package App\Core
 */
class ErrorHandler extends CustomHandler
{
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
            ->withStatus(self::INTERNAL_SERVER_ERROR_CODE)
            ->withHeader('Content-Type', 'text/html')
            ->write('Something went wrong.');
    }
}
