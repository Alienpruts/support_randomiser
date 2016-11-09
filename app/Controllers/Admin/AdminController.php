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

    public function getUserCreate(Request $req, Response $res)
    {
        //create user form
        return $this->view->render($res, 'templates/admin/usercreate.twig');
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

        //TODO : create user using admin instance

        $this->flash->addMessage('info', 'New user %%name%% created');
        return $res->withRedirect($this->router->pathFor('admin.usercreate'));
    }
}