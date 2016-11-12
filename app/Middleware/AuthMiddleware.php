<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 11/12/16
 * Time: 10:20 PM
 */

namespace Alienpruts\SupportRandomiser\Middleware;


use Slim\Http\Request;
use Slim\Http\Response;

class AuthMiddleware extends BaseMiddleware
{
    public function __invoke(Request $req, Response $res, $next)
    {
        if (!$this->container->get('auth')->check()) {
            $this->container->get('flash')->addMessage('error', 'You need to be logged in to do that');
            return $res->withRedirect($this->container->get('router')->pathFor('home'));
        }

        $res = $next($req, $res);
        return $res;
    }

}