<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 10/27/16
 * Time: 9:17 PM
 */

namespace Alienpruts\SupportRandomiser\Controllers;


use Slim\Http\Request;
use Slim\Http\Response;

class HomeController extends BaseController
{
    public function index(Request $req, Response $res)
    {
        //TODO : render homepage view

        return $res->getBody()->write('HomeController:index is working');
    }
}