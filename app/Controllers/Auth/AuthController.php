<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 10/27/16
 * Time: 10:40 PM
 */

namespace Alienpruts\SupportRandomiser\Controllers\Auth;

use Alienpruts\SupportRandomiser\Controllers\BaseController;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

/**
 * @property Twig view
 */
class AuthController extends BaseController
{
    public function getSignin(Request $req, Response $res)
    {
        return $this->view->render($res, 'templates/auth/signin.twig');
    }


}