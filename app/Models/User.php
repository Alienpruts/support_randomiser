<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 10/26/16
 * Time: 9:37 PM
 */

namespace Alienpruts\SupportRandomiser\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'Users';

    protected $fillable = [
      'naam',
      'email',
      'paswoord',
      'score'
    ];

    public function setPassword($password)
    {
        // set password on user
        // TODO : save using hash !!
        return $this->update([
            'paswoord' => $password,
          ]
        );
    }

    public function setEmail($email)
    {
        return $this->update([
          'email' => $email,
        ]);
    }

}