<?php

/**
 * Handles 404 not found errors.
 */

namespace App\Handler;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class NotFoundHandler
 *
 * @package App\Handler
 */
class NotFoundHandler extends CustomHandler
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
        $this->logger->error($exception->getMessage());
        return $response
            ->withStatus(self::NOT_FOUND_CODE)
            ->withHeader('Content-Type', 'text/html')
            ->write('Not found.');
    }
}
