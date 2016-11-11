<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 10/24/16
 * Time: 11:55 PM
 */

$app->get('/', 'HomeController:index')->setName('home');

$app->get('/auth/signin', 'AuthController:getSignin')->setName('auth.signin');
$app->post('/auth/signin', 'AuthController:postSignin');

$app->get('/auth/signout', 'AuthController:getSignOut')->setName('auth.signout');

$app->get('/auth/edit', 'AuthController:getEdit')->setName('auth.edit');
$app->post('/auth/edit', 'AuthController:postEdit');

$app->get('/{year:[0-9]+}/week/{weeknr:[0-9]+}', 'WeekController:getWeek')->setName('week.getweek');

//TODO : access check, for admin users only.
$app->get('/admin', 'AdminController:index')->setName('admin.home');

$app->get('/admin/user/overview', 'AdminController:getOverview')->setName('admin.useroverview');

$app->get('/admin/user/create', 'AdminController:getUserCreate')->setName('admin.usercreate');
$app->post('/admin/user/create', 'AdminController:postUserCreate');

$app->get('/admin/user/{userid:[0-9]+}/edit', 'AdminController:getUserEdit')->setName('admin.useredit');
$app->post('/admin/user/{userid:[0-9]+}/edit', 'AdminController:postUserEdit');