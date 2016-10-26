<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 10/26/16
 * Time: 10:28 PM
 */

namespace Alienpruts\SupportRandomiser\Models;

use Illuminate\Database\Eloquent\Model;

class Weeks extends Model
{
    protected $table = 'Weeks';

    protected $fillable = [
      'weeknr',
      'jaar',
    ];
}