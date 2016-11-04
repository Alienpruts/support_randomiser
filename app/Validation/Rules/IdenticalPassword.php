<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 11/4/16
 * Time: 10:11 AM
 */

namespace Alienpruts\SupportRandomiser\Validation\Rules;


use Respect\Validation\Rules\AbstractRule;

class IdenticalPassword extends AbstractRule
{
    private $old_password;

    public function __construct($old_password)
    {
        $this->old_password = $old_password;
    }

    public function validate($input)
    {
        // If password and input are equal return false to validator.
        return (strcmp($input, $this->old_password) <> 0);
    }
}