<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 11/3/16
 * Time: 11:08 PM
 */

namespace Alienpruts\SupportRandomiser\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

class OldInputMiddleware extends BaseMiddleware
{
    public function __invoke(Request $req, Response $res, $next)
    {
        if (isset($_SESSION['old'])) {
            $this->container->view->getEnvironment()
              ->addGlobal('old', $_SESSION['old']);
        }

        $_SESSION['old'] = $req->getParams();
        unset($_SESSION['old']['password']);

        $res = $next($req, $res);

        return $res;
    }

}