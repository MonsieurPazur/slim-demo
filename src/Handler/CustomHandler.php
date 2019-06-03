<?php

/**
 * Wraps common handler logic.
 */

namespace App\Handler;

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

/**
 * Class CustomHandler
 *
 * @package App\Handler
 */
abstract class CustomHandler
{
    /**
     * @var int codes used in custom error handlers
     */
    protected const INTERNAL_SERVER_ERROR_CODE = 500;
    protected const METHOD_NOT_ALLOWED_CODE = 405;
    protected const NOT_FOUND_CODE = 404;

    /**
     * @var LoggerInterface $logger used to log error
     */
    protected $logger;

    /**
     * ErrorHandler constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->logger = $container->get('logger');
    }
}
