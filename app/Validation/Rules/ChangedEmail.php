<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 11/4/16
 * Time: 10:11 AM
 */

namespace Alienpruts\SupportRandomiser\Validation\Rules;


use Respect\Validation\Rules\AbstractRule;

class ChangedEmail extends AbstractRule
{

    protected $current;


    public function __construct($current)
    {
        $this->current = $current;
    }

    public function validate($input)
    {
        // Check if input is a new emailaddress for this user.
        return !($input === $this->current);
    }
}