<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 10/27/16
 * Time: 9:57 PM
 */

namespace Alienpruts\SupportRandomiser\Middleware;


use Slim\Http\Request;
use Slim\Http\Response;

class AccessLogMiddleware extends BaseMiddleware
{
    public function __invoke(Request $req, Response $res, $next)
    {

        $logger = $this->container->get('accesslogger');
        $logger->addNotice('Request: ' . $req->getMethod() . ' | ' . $req->getUri() . ' | Status : ' . $res->getStatusCode());

        $res = $next($req, $res);
        return $res;
    }


}