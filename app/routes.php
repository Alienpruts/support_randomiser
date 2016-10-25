<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 10/24/16
 * Time: 11:55 PM
 */

use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/hello/{name}', function (Request $req, Response $res, $args) {
    $this->debuglogger->addDebug('Allright, Monolog Logger seems to be working. Well done!' . $args['name']);
    $this->accesslogger->addNotice('Request: ' . $req->getMethod() . ' | ' . $req->getUri() . ' | Status : ' . $res->getStatusCode());
    d('Kint seems to be working, this is the Request object');
    d($req);
    return $this->view->render($res, 'index.twig', [
      'name' => $args['name'],
    ]);
});