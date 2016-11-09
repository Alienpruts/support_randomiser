<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 11/4/16
 * Time: 10:00 AM
 */

namespace Alienpruts\SupportRandomiser\Validation\Exceptions;


use Respect\Validation\Exceptions\ValidationException;

class UniqueNameException extends ValidationException
{
    public static $defaultTemplates = [
      self::MODE_DEFAULT => [
        self::STANDARD => 'User name already exists in database. Please choose another name',
      ],
    ];

}