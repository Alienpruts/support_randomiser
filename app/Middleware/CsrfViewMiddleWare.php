<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 11/4/16
 * Time: 11:17 PM
 */

namespace Alienpruts\SupportRandomiser\Middleware;


use Slim\Http\Request;
use Slim\Http\Response;

class CsrfViewMiddleWare extends BaseMiddleware
{
    public function __invoke(Request $req, Response $res, $next)
    {

        $this->container->view->getEnvironment()->addGlobal('csrf', [
          'field' => '
            <input type="hidden" name="' . $this->container->csrf->getTokenNameKey() . '" value="' . $this->container->csrf->getTokenName() . '">
            <input type="hidden" name="' . $this->container->csrf->getTokenValueKey() . '" value="' . $this->container->csrf->getTokenValue() . '">
          '
        ]);

        $res = $next($req, $res);
        return $res;
    }


}