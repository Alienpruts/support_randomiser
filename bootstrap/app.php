<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 10/24/16
 * Time: 11:31 PM
 */


use Alienpruts\SupportRandomiser\Configurator\Configurator;

session_start();
date_default_timezone_set('Europe/Brussels');

require_once __DIR__ . '/../vendor/autoload.php';

$config = new Configurator();

$app = new Slim\App($config->getConfiguration());

require_once __DIR__ . '/../app/routes.php';
