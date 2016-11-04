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
        // Check if current password is valid.
        return password_verify($input, $this->user->paswoord);
    }
}