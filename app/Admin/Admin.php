<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 11/9/16
 * Time: 11:38 PM
 */

namespace Alienpruts\SupportRandomiser\Admin;

use Alienpruts\SupportRandomiser\Models\User;
use Slim\Exception\SlimException;

class Admin
{
    private $access;

    public function __construct($user = null)
    {
        $this->access = $this->checkAccess($user);
    }

    // Check if user name is already taken.
    public function checkName($name)
    {

        if (!$this->access) {
            // TODO : this should be an Exception instead of a false.
            return false;
        }

        $user = User::where('naam', '=', $name)->first();

        if (!$user) {
            return false;
        }

        return true;
    }

    /**
     * Does current user have access to this class?
     */
    private function checkAccess($user)
    {

        // TODO : dummy check, rework check!
        if (!$user->naam == 'bert') {
            return false;
        }

        return true;

    }

}