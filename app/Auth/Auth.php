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

    /**
     * Updates logged in User using data from the account edit form.
     *
     * @param array $data
     *  Array containing the data from the form.
     * @return bool
     *  Returns TRUE if update succeeded, FALSE otherwise.
     */
    public function updateUser(array $data)
    {
        // Always assume the update has failed, unless proven otherwise.
        $result = false;

        $user = $this->user();

        // Update emailadress.
        if ($user && $user->setEmail($data['email'])) {
            $result = true;
        }

        // Password field is different, validation for empty values has been dis-
        // abled (for edit forms). Note that Previous updates need to have succeeded
        // before this one should take place.
        if (!empty($data['password']) && $result) {
            return $user->setPassword($data['password']);
        }

        return $result;
    }
}