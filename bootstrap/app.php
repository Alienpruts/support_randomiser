<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 10/24/16
 * Time: 11:31 PM
 */


use Alienpruts\SupportRandomiser\Auth\Auth;
use Alienpruts\SupportRandomiser\Configurator\Configurator;
use Alienpruts\SupportRandomiser\Controllers\Auth\AuthController;
use Alienpruts\SupportRandomiser\Controllers\HomeController;
use Alienpruts\SupportRandomiser\Middleware\AccessLogMiddleware;
use Alienpruts\SupportRandomiser\Middleware\OldInputMiddleware;
use Alienpruts\SupportRandomiser\Middleware\ValidationErrorsMiddleware;
use Alienpruts\SupportRandomiser\Validation\Validator;
use Illuminate\Database\Capsule\Manager;
use Respect\Validation\Validator as v;
use Slim\Flash\Messages;

session_start();
date_default_timezone_set('Europe/Brussels');

require_once __DIR__ . '/../vendor/autoload.php';

$config = new Configurator();

$app = new Slim\App($config->getConfiguration());

$container = $app->getContainer();

$capsule = new Manager();
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($container) use ($capsule) {
    return $capsule;
};

$container['auth'] = function ($container) {
    return new Auth();
};

$container['HomeController'] = function ($container) {
    return new HomeController($container);
};

$container['AuthController'] = function ($container) {
    return new AuthController($container);
};

$container['validator'] = function () {
    return new Validator();
};

$container['flash'] = function () {
    return new Messages();
};

$app->add(new AccessLogMiddleware($container));

$app->add(new OldInputMiddleware($container));

$app->add(new ValidationErrorsMiddleware($container));

v::with('Alienpruts\\SupportRandomiser\\Validation\\Rules');

require_once __DIR__ . '/../app/routes.php';
