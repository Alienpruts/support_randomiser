<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 10/24/16
 * Time: 11:55 PM
 */

$app->get('/', 'HomeController:index')->setName('home');

$app->get('/auth/signin', 'AuthController:getSignin')->setName('auth.signin');