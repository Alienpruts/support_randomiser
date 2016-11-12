<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 10/24/16
 * Time: 11:55 PM
 */

use Alienpruts\SupportRandomiser\Middleware\AdminMiddleware;
use Alienpruts\SupportRandomiser\Middleware\AuthMiddleware;

$app->get('/', 'HomeController:index')->setName('home');

$app->get('/auth/signin', 'AuthController:getSignin')->setName('auth.signin');
$app->post('/auth/signin', 'AuthController:postSignin');

$app->group('', function () use ($app) {
    $this->get('/auth/signout', 'AuthController:getSignOut')
      ->setName('auth.signout');

    $this->get('/auth/edit', 'AuthController:getEdit')->setName('auth.edit');
    $this->post('/auth/edit', 'AuthController:postEdit');
})->add(new AuthMiddleware($container));



$app->get('/{year:[0-9]+}/week/{weeknr:[0-9]+}', 'WeekController:getWeek')
  ->setName('week.getweek');

//TODO : access check, for admin users only, do this on all /admin/* paths.
$app->group('', function () use ($app) {
    $this->get('/admin/', 'AdminController:index')->setName('admin.home');

    $this->get('/admin/user/overview', 'AdminController:getOverview')
      ->setName('admin.useroverview');

    $this->get('/admin/user/create', 'AdminController:getUserCreate')
      ->setName('admin.usercreate');
    $this->post('/admin/user/create', 'AdminController:postUserCreate');

    $this->get('/admin/user/{userid:[0-9]+}/edit', 'AdminController:getUserEdit')
      ->setName('admin.useredit');
    $this->post('/admin/user/{userid:[0-9]+}/edit', 'AdminController:postUserEdit');

    $this->get('/admin/user/{userid:[0-9]+}/delete', 'AdminController:getUserDelete')
      ->setName('admin.userdelete');
    $this->post('/admin/user/{userid:[0-9]+}/delete',
      'AdminController:postUserDelete');
})->add(new AdminMiddleware($container));
