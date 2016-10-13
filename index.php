<?php

use Alienpruts\SupportRandomiser\Test;
use Slim\Http\Request;
use Slim\Http\Response;

require 'vendor/autoload.php';
require 'config/settings.php';

$config = get_configuration();

$app = new Slim\App($config);

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

$app->run();