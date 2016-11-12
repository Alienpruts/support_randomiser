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
    private $uid;

    public function __construct($admin, $uid = NULL)
    {
        $this->admin = $admin;
        $this->uid = $uid;
    }

    public function validate($input)
    {
        $user = $this->admin->checkName($input);

        if ($this->uid && $user) {
            return $this->uid == $user->id ;
        }

        return !$user;
    }
}