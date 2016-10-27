<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 10/27/16
 * Time: 9:18 PM
 */

namespace Alienpruts\SupportRandomiser\Controllers;

use Exception;
use Slim\Container;

class BaseController
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function __get($name)
    {
        try {
            $result = $this->container->get($name);
        } catch (Exception $e) {
            throw new Exception("Could not retrieve property {$name} from container!");
        }

        return $result;
    }


}