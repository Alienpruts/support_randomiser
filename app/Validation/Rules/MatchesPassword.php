<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 11/4/16
 * Time: 9:59 AM
 */

namespace Alienpruts\SupportRandomiser\Validation\Rules;


use Respect\Validation\Rules\AbstractRule;

class MatchesPassword extends AbstractRule
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function validate($input)
    {
        // If empty input : validate anyway. There is no way the current password
        // can be empty, so skip verifying empty passwords.
        if (!$input) {
            return true;
        }

        // Check if current password is valid.
        return password_verify($input, $this->user->paswoord);
    }
}