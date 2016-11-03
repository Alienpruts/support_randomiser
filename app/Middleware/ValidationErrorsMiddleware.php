<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 11/3/16
 * Time: 11:46 PM
 */

namespace Alienpruts\SupportRandomiser\Middleware;


use Slim\Http\Request;
use Slim\Http\Response;

class ValidationErrorsMiddleware extends BaseMiddleware
{
    public function __invoke(Request $req, Response $res, $next)
    {
        if (isset($_SESSION['errors'])) {
            $this->container->view->getEnvironment()
              ->addGlobal('errors', $_SESSION['errors']);
        }

        if (isset($_SESSION['errors'])) {
            unset($_SESSION['errors']);
        }

        $res = $next($req, $res);

        return $res;
    }


}