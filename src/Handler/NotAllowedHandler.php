<?php

/**
 * Handles 405 method not allowed errors.
 */

namespace App\Handler;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class NotAllowedHandler
 *
 * @package App\Handler
 */
class NotAllowedHandler extends CustomHandler
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
        try {
            $this->logger->error($exception->getMessage());
        } catch (Exception $e) {
        } finally {
            return $response
                ->withStatus(self::METHOD_NOT_ALLOWED_CODE)
                ->withHeader('Content-Type', 'text/html')
                ->write('Method not allowed.');
        }
    }
}
