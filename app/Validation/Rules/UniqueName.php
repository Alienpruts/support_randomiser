<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 11/9/16
 * Time: 10:55 PM
 */

namespace Alienpruts\SupportRandomiser\Validation\Rules;


use Respect\Validation\Rules\AbstractRule;
use Slim\Container;

/**
 * @property Container container
 */
class UniqueName extends AbstractRule
{
    private $admin;

    public function __construct($admin)
    {
        $this->admin = $admin;
    }

    public function validate($input)
    {
        // check database if input name is unique
        return !$this->admin->checkName($input);
    }
}