<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 11/9/16
 * Time: 11:38 PM
 */

//TODO : rework access checking, because now we have to check the var for every method.

namespace Alienpruts\SupportRandomiser\Admin;

use Alienpruts\SupportRandomiser\Models\User;

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

        return $user;
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

    public function hasAccess()
    {
        return $this->access;

    }

    public function createUser(array $data)
    {
        if ($this->access) {

            $user = new User();
            $user->naam = $data['name'];
            $user->email = $data['email'];
            $user->paswoord = password_hash($data['paswoord'],
              PASSWORD_DEFAULT);
            $user->score = 0;

            return $user->save();
        }

        return false;
    }

}