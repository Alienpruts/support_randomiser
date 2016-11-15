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
use Slim\Flash\Messages;
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
 * @property Messages flash
 */
class AuthController extends BaseController
{
    public function getSignin(Request $req, Response $res)
    {
        if ($this->auth->check()) {
            $this->flash->addMessage('info',
              'You are already signed in. Redirecting to profile edit page.');
            return $res->withRedirect($this->router->pathFor('auth.edit'));
        }
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
            $this->flash->addMessage('error',
              'Could not sign in with provided credentials. Please try again!');
            return $res->withRedirect($this->router->pathFor('auth.signin'));
        }

        return $res->withRedirect($this->router->pathFor('home'));
    }

    public function getSignOut(Request $req, Response $res)
    {
        $this->auth->signout();

        $this->flash->addMessage('info', 'Successfully logged out');
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

        $validation = $this->validator->validate($req, [
          'email' => v::noWhitespace()
            ->notEmpty()
            ->email()
            ->when(v::changedEmail($this->auth->user()->email),
              v::uniqueEmail(), v::alwaysValid()),
          'old_password' => v::noWhitespace()
            ->when(v::notEmpty(), v::matchesPassword($this->auth->user()),
              v::alwaysValid()),
          'password' => v::noWhitespace()
            ->when(v::notEmpty(),
              v::oldPasswordNotEmpty($req->getParam('old_password')),
              v::alwaysValid())
            ->when(v::notEmpty(), v::length(8), v::alwaysValid()),
        ]);


        if ($validation->failed()) {
            $this->flash->addMessage('error',
              'There was an error processing this form. Please correct all fields in red.');
            return $res->withRedirect($this->router->pathFor('auth.edit'));
        }

        if (!$this->auth->updateUser($req->getParams())) {
            $this->flash->addMessage('error',
              'There was an error trying to update your account //TODO Exception error message//.');
            return $res->withRedirect($this->router->pathFor('auth.edit'));
        }

        $this->flash->addMessage('info', 'Account successfully updated');
        return $res->withRedirect($this->router->pathFor('home'));
    }

}