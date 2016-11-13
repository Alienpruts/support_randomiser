<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 11/9/16
 * Time: 11:38 PM
 */

namespace Alienpruts\SupportRandomiser\Admin;

use Alienpruts\SupportRandomiser\Models\User;

class Admin
{
    private $access;

    public function __construct($user = null)
    {
        $this->access = $this->setAccess($user);
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
     * Sets admin access depending on user role.
     *
     * @param User|null $user
     *  Given User object or NUll
     * @return bool
     *  Returns TRUE if user has Admin role, FALSE otherwise.
     */
    private function setAccess($user)
    {
        if (!$user) {
            return false;
        }

        if (!($user->role == 'Admin')) {
            return false;
        }

        return true;
    }

    /**
     * Getter for access field.
     * @return bool
     */
    public function hasAccess()
    {
        return $this->access;

    }

    /**
     * Creates a new User with the results from the create user form.
     *
     * @param array $data
     *  Array with field values from the form.
     * @return bool
     *  Returns TRUE if new User has been saved to table, FALSE otherwise.
     */
    public function createUser(array $data)
    {
        if ($this->access) {

            $user = new User();
            $user->naam = $data['name'];
            $user->email = $data['email'];
            $user->paswoord = password_hash($data['paswoord'],
              PASSWORD_DEFAULT);
            $user->role = $data['role'];
            $user->score = 0;

            return $user->save();
        }

        return false;
    }

    /**
     * Updates a given User using data from the user edit form.
     *
     * @param $userid
     *  The user id to perform the update on.
     * @param array $data
     *  Array containing the data from the form.
     * @return bool
     *  Returns TRUE if update succeeded, FALSE otherwise.
     */
    public function updateUser($userid, array $data)
    {
        // Always assume the update has failed, unless proven otherwise.
        $result = false;

        $user = User::find($userid);

        // If a user is found.
        if ($user && ($user->setEmail($data['email']) &&
            $user->setNaam($data['name']) &&
            $user->setRole($data['role']))) {
            $result = true;
        }

        // Password field is different, validation for empty values has been dis-
        // abled (for edit forms). Note that Previous updates need to have succeeded
        // before this one should take place.
        if (!empty($data['new_password']) && $result) {
            return $user->setPassword($data['new_password']);
        }

        return $result;
    }

}