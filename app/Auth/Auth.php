<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 11/1/16
 * Time: 10:56 AM
 */

namespace Alienpruts\SupportRandomiser\Auth;

use Alienpruts\SupportRandomiser\Models\User;

class Auth
{

    public function attempt($email, $password)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return false;
        }

        if (password_verify($password, $user->paswoord)) {
            $_SESSION['uid'] = $user->id;
            return true;
        }

        return false;
    }

    public function user()
    {
        if (!isset($_SESSION['uid'])) {
            return false;
        }
        $user = User::find($_SESSION['uid']);

        return $user;
    }

    public function check()
    {
        return isset($_SESSION['uid']);
    }

    public function signout()
    {
        if (isset($_SESSION['uid'])) {
            unset($_SESSION['uid']);
        }
    }
}