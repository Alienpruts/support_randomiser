<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 10/27/16
 * Time: 10:40 PM
 */

namespace Alienpruts\SupportRandomiser\Controllers\Auth;

use Alienpruts\SupportRandomiser\Auth\Auth;
use Alienpruts\SupportRandomiser\Controllers\BaseController;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;
use Slim\Views\Twig;

/**
 * @property Twig view
 * @property Auth auth
 * @property Router router
 */
class AuthController extends BaseController
{
    public function getSignin(Request $req, Response $res)
    {
        return $this->view->render($res, 'templates/auth/signin.twig');
    }

    public function postSignin(Request $req, Response $res)
    {

        $authenticated = $this->auth->attempt(
          $req->getParam('email'),
          $req->getParam('password')
        );

        // If authentication retrieval failed, redirect to signin page.
        if (!$authenticated) {
            // TODO : set message of some sort?
            return $res->withRedirect($this->router->pathFor('auth.signin'));
        }

        return $res->withRedirect($this->router->pathFor('home'));
    }

    public function getSignOut(Request $req, Response $res)
    {
        $this->auth->signout();

        // TODO : set message to notify of logout.
        return $res->withRedirect($this->router->pathFor('home'));
    }

}