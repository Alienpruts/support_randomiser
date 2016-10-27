<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 10/27/16
 * Time: 9:59 PM
 */

namespace Alienpruts\SupportRandomiser\Middleware;


class BaseMiddleware
{
    /**
     * @var \Interop\Container\ContainerInterface
     */
    protected $container;

    /**
     * AccessLogMiddleware constructor.
     * @param \Interop\Container\ContainerInterface $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }
}