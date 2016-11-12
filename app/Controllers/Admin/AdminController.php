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
        // Check if current user has permission to create Users.
        if (!$this->admin->hasAccess()) {
            $this->flash->addMessage('error',
              'Sorry, you do not have permission to view users.');
            return $res->withRedirect($this->router->pathFor('admin.home'));
        }
        $users = User::all()->all();
        return $this->view->render($res, 'templates/admin/user_overview.twig', [
          'users' => $users,
        ]);
    }

    public function getUserCreate(Request $req, Response $res)
    {
        // Check if current user has permission to create Users.
        if (!$this->admin->hasAccess()) {
            $this->flash->addMessage('error',
              'Sorry, you do not have permission to create users.');
            return $res->withRedirect($this->router->pathFor('admin.useroverview'));
        }

        //create user form
        return $this->view->render($res, 'templates/admin/usercreate.twig');
    }

    public function getUserEdit(Request $req, Response $res, $args)
    {

        // Does current user have permission to do an update of User?
        if (!$this->admin->hasAccess()) {
            $this->flash->addMessage('error',
              'Sorry, you do not have permission to update users.');
            return $res->withRedirect($this->router->pathFor('admin.useroverview'));
        }

        $user = User::find($args['userid']);
        return $this->view->render($res, 'templates/admin/useredit.twig', [
          'user' => $user,
        ]);
    }

    public function postUserEdit(Request $req, Response $res, $args)
    {

        // Validate input.
        $validation = $this->validator->validate($req, [
          'name' => v::notEmpty()->uniqueName($this->admin, $args['userid']),
          'email' => v::noWhitespace()->email()->notEmpty(),
        ]);

        // We need to allow empty password fields on a edit, the user might not
        // want to change password.
        if (!empty($req->getParam('new_password') && !empty($req->getParam('confirm_password')))) {
            $validation = $this->validator->validate($req, [
              'new_password' => v::length(8)->noWhitespace(),
              'confirm_password' => v::length(8)->noWhitespace()
                //TODO : equals return new_password as string in Exception !!!
                ->equals($req->getParam('new_password')),
            ]);
        }


        if ($validation->failed()) {
            $this->flash->addMessage('error',
              'There was an error processing this form. Please correct all fields in red.');
            return $res->withRedirect($this->router->pathFor('admin.useredit',
              ['userid' => $args['userid']]));
        }

        if (!$this->admin->updateUser($args['userid'], $req->getParams())) {
            $this->flash->addMessage('error',
              'There was an error trying to update user //NAME. //TODO Exception error message//.');
            return $res->withRedirect($this->router->pathFor('admin.useredit'));
        }

        $this->flash->addMessage('info',
          'User ' . $req->getParam('name') . 'has been updated');
        return $res->withRedirect($this->router->pathFor('admin.useroverview'));

    }

    public function postUserCreate(Request $req, Response $res)
    {

        // Validate input.
        $validation = $this->validator->validate($req, [
          'name' => v::notEmpty()->uniqueName($this->admin),
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

        if (!$this->admin->createUser($req->getParams())) {
            $this->flash->addMessage('error',
              'Could not create new user //TODO Exception error message//.');
            return $res->withRedirect($this->router->pathFor('admin.usercreate'));
        }

        $this->flash->addMessage('info',
          'New user ' . $req->getParam('name') . 'created');
        //TODO redirect to admin control page
        return $res->withRedirect($this->router->pathFor('admin.useroverview'));
    }

    public function getUserDelete(Request $req, Response $res, $args)
    {
        if (!$this->admin->hasAccess()) {
            $this->flash->addMessage('error',
              'Sorry, you do not have permission to delete users.');
            return $res->withRedirect($this->router->pathFor('admin.useroverview'));
        }
        $user = User::find($args['userid']);
        return $this->view->render($res, 'templates/admin/userdelete.twig', [
          'user' => $user
        ]);
    }

    public function postUserDelete(Request $req, Response $res, $args)
    {
        $count = User::destroy($args['userid']);
        if (!$count === 1) {
            $this->flash->addMessage('warning',
              'Something went wrong deleting this user. Method destroy() reported ' . $count . 'models affected! (should be 1)');
        } else {
            $this->flash->addMessage('info',
              'User ' . $args['userid'] . ' successfully deleted');
        }

        return $res->withRedirect($this->router->pathFor('admin.useroverview'));

    }
}