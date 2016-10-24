<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 10/24/16
 * Time: 11:55 PM
 */


use Alienpruts\SupportRandomiser\Test\Test;
use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/hello/{name}', function (Request $req, Response $res, $args) {
    $this->logger->addNotice('Allright, Monolog Logger seems to be working. Well done!' . $args['name']);
    d('Kint seems to be working, this is the Request object');
    d($req);
    $test = new Test();
    d($test->testThis('Yoooooo'));
    return $this->view->render($res, 'index.twig', [
      'name' => $args['name'],
    ]);
});