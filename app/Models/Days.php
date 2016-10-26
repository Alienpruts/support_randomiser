<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 10/26/16
 * Time: 10:27 PM
 */

namespace Alienpruts\SupportRandomiser\Models;

use Illuminate\Database\Eloquent\Model;

class Days extends Model
{
    protected $table = 'Days';
    protected $fillable = [
      'dagnr',
      'weeknr',
      'user',
      'accepted'
    ];
}