<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 11/4/16
 * Time: 10:00 AM
 */

namespace Alienpruts\SupportRandomiser\Validation\Exceptions;


use Respect\Validation\Exceptions\ValidationException;

class IdenticalPasswordException extends ValidationException
{
    public static $defaultTemplates = [
      self::MODE_DEFAULT => [
        self::STANDARD => 'New password is identical to current password. Please choose a different password',
      ],
    ];

}