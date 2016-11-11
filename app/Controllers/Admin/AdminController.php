<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 11/9/16
 * Time: 10:23 PM
 */

namespace Alienpruts\SupportRandomiser\Controllers\Admin;


use Alienpruts\SupportRandomiser\Admin\Admin;
use Alienpruts\SupportRandomiser\Auth\Auth;
use Alienpruts\SupportRandomiser\Controllers\BaseController;
use Alienpruts\SupportRandomiser\Models\User;
use Alienpruts\SupportRandomiser\Validation\Validator;
use Slim\Flash\Messages;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;
use Slim\Views\Twig;
use Respect\Validation\Validator as v;

/**
 * @property Twig view
 * @property Validator validator
 * @property Messages flash
 * @property Router router
 * @property Admin admin
 * @property Auth auth
 */
class AdminController extends BaseController
{

    public function index(Request $req, Response $res)
    {
        // Render admin specific Twig template.
        return $this->view->render($res, 'templates/admin/index.twig');
    }

    public function getOverview(Request $req, Response $res)
    {
        // Render user overview Twig template.
        // Get all users from system
        $users = User::all()->all();
        return $this->view->render($res, 'templates/admin/user_overview.twig', [
          'users' => $users,
        ]);
    }

    public function getUserCreate(Request $req, Response $res)
    {
        //create user form
        return $this->view->render($res, 'templates/admin/usercreate.twig');
    }

    public function getUserEdit(Request $req, Response $res, $args)
    {
        $user = User::find($args['userid']);
        return $this->view->render($res, 'templates/admin/useredit.twig', [
          'user' => $user,
        ]);
    }

    public function postUserEdit(Request $req, Response $res, $args) {
        //validate input
        //edit user
        $user = User::find($args['userid']);
        $admin = new Admin($this->auth->user());

        // Validate input.
        $validation = $this->validator->validate($req, [
          'name' => v::notEmpty()->uniqueName($admin, $user->id),
          'email' => v::noWhitespace()->email()->notEmpty(),
          'new_password' => v::noWhitespace()
            ->notEmpty()
            ->length(8),
          'confirm_password' => v::noWhitespace()
            ->notEmpty()
            ->length(8)
            //TODO : equals return new_password as string in Exception !!!
            ->equals($req->getParam('new_password')),
        ]);

        if ($validation->failed()) {
            $this->flash->addMessage('error',
              'There was an error processing this form. Please correct all fields in red.');
            return $res->withRedirect($this->router->pathFor('admin.useredit', ['userid' => $user->id ]));
        }

    }

    public function postUserCreate(Request $req, Response $res)
    {
        // Admin instance for Admin related queries.
        $admin = new Admin($this->auth->user());

        // Validate input.
        $validation = $this->validator->validate($req, [
          'name' => v::notEmpty()->uniqueName($admin),
          'email' => v::noWhitespace()->email()->notEmpty(),
          'password' => v::noWhitespace()
            ->notEmpty()
            ->length(8),
        ]);

        if ($validation->failed()) {
            $this->flash->addMessage('error',
              'There was an error processing this form. Please correct all fields in red.');
            return $res->withRedirect($this->router->pathFor('admin.usercreate'));
        }

        // TODO : Data has already been validated, sanitation needed with ORM?
        if (!$admin->hasAccess()) {
            $this->flash->addMessage('error',
              'Sorry, the current logged in user does not have the permission to create a new user.');
            return $res->withRedirect($this->router->pathFor('admin.usercreate'));
        }

        if (!$admin->createUser($req->getParams())) {
            $this->flash->addMessage('error',
              'Could not create new user //TODO Exception error message//.');
            return $res->withRedirect($this->router->pathFor('admin.usercreate'));
        }

        $this->flash->addMessage('info',
          'New user ' . $req->getParam('name') . 'created');
        //TODO redirect to admin control page
        return $res->withRedirect($this->router->pathFor('home'));
    }
}