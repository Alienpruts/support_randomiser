<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Slim\Container;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

date_default_timezone_set('Europe/Brussels');

/**
 * Get configuration options for the app.
 * @return array
 *  Returns array of configuration options
 */
function get_configuration()
{
    // TODO : this needs to be rethought!!!
    $config = [
      'settings' => [
        'displayErrorDetails' => true,
      ],
      'logger' => function () {
          $logger = new Logger('Test Monolog Logger');
          $file_handler = new StreamHandler("logs/app.log");
          $logger->pushHandler($file_handler);
          return $logger;
      },
      'view' => function (Container $c) {
          $view = new Twig('templates', [
            'cache' => 'cache/twig',
            'debug' => true,
          ]);
          $view->addExtension(new TwigExtension(
              $c['router'],
              $c['request']->getUri())
          );
          $view->addExtension(new Twig_Extension_Debug());

          return $view;
      },
    ];

    return $config;
}