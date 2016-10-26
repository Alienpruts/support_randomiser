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

}