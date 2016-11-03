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
use Alienpruts\SupportRandomiser\Validation\Validator;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;
use Slim\Views\Twig;
use Respect\Validation\Validator as v;

/**
 * @property Twig view
 * @property Auth auth
 * @property Router router
 * @property Validator validator
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

    public function getEdit(Request $req, Response $res)
    {
        // Get edit form for current user, if logged in
        if (!($this->auth->check())) {
            //return to home page, invalid route !!!
            var_dump('not logged in!');
            return $res->withRedirect($this->router->pathFor('home'));
        }

        return $this->view->render($res, 'templates/auth/edit.twig');
    }

    public function postEdit(Request $req, Response $res)
    {

        // TODO : check if current password is correct (custom rule).
        $validation = $this->validator->validate($req, [
          'email' => v::noWhitespace()->notEmpty()->email(),
          'password' => v::noWhitespace()->notEmpty()->min(8),
        ]);

        if ($validation->failed()) {
            // TODO : flash messages
            return $res->withRedirect($this->router->pathFor('auth.edit'));
        }

        // TODO : check if updates failed or not.
        $updated_password = $this->auth->user()
          ->setPassword($req->getParam('password'));
        $updated_email = $this->auth->user()->setEmail($req->getParam('email'));

        // TODO Flash message to indicate succes or failure.

        return $res->withRedirect($this->router->pathFor('home'));
    }

}