<?php

/**
 * Keeps common Controller logic in one place.
 */

namespace App\Controller;

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

/**
 * Class Controller
 *
 * @package App\Controller
 */
abstract class Controller
{
    /**
     * @var ContainerInterface $container
     */
    protected $container;

    /**
     * @var LoggerInterface $logger
     */
    protected $logger;

    /**
     * Controller constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->logger = $this->container->get('logger');
    }
}
