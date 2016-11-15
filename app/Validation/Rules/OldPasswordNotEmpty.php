<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 11/4/16
 * Time: 10:11 AM
 */

namespace Alienpruts\SupportRandomiser\Validation\Rules;


use Respect\Validation\Rules\AbstractRule;

class OldPasswordNotEmpty extends AbstractRule
{

    protected $old_password;


    public function __construct($old_password)
    {
        $this->old_password = $old_password;
    }

    public function validate($input)
    {
        // Check if old_password has been filled in
        return !empty($this->old_password);
    }
}