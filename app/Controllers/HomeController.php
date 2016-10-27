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
use Slim\Views\Twig;

/**
 * @property Twig view
 */
class HomeController extends BaseController
{
    public function index(Request $req, Response $res)
    {
        return $this->view->render($res, 'home.twig');
    }
}