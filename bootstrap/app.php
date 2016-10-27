<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 10/24/16
 * Time: 11:31 PM
 */


use Alienpruts\SupportRandomiser\Configurator\Configurator;
use Alienpruts\SupportRandomiser\Controllers\HomeController;
use Alienpruts\SupportRandomiser\Middleware\AccessLogMiddleware;
use Illuminate\Database\Capsule\Manager;

session_start();
date_default_timezone_set('Europe/Brussels');

require_once __DIR__ . '/../vendor/autoload.php';

$config = new Configurator();

$app = new Slim\App($config->getConfiguration());

$container = $app->getContainer();

$container['eloquent'] = function ($container) {
    $capsule = new Manager();
    $capsule->addConnection($container['db']);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    return $capsule;
};

$container['HomeController'] = function ($container) {
    return new HomeController($container);
};

$app->add(new AccessLogMiddleware($container));

require_once __DIR__ . '/../app/routes.php';
