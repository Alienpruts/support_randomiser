<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 11/4/16
 * Time: 10:11 AM
 */

namespace Alienpruts\SupportRandomiser\Validation\Rules;


use Alienpruts\SupportRandomiser\Models\User;
use Respect\Validation\Rules\AbstractRule;

class UniqueEmail extends AbstractRule
{

    public function validate($input)
    {
        // Check if email is not already present on a user.
        $user = User::where('email', '=', $input)->first();

        return !($user);
    }
}