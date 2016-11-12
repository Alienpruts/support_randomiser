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

    /**
     * Sets password on the User model.
     *
     * @param string $password
     *  The password to set on the model.
     * @return bool
     *  Returns TRUE if update of the field succeeded, FALSE if $password is empty OR update failed.
     */
    public function setPassword($password)
    {
        // There is one instance where password field can be empty : edit form
        // TODO : better way of handling this?
        if (!$password) {
            return false;
        }

        return $this->update([
            'paswoord' => password_hash($password, PASSWORD_DEFAULT),
          ]
        );
    }

    /**
     * Sets email on the User model.
     *
     * @param string $email
     *  The email to set on the model.
     * @return bool
     *  Returns TRUE if update of the field succeeded, FALSE if $email is empty OR update failed.
     */
    public function setEmail($email)
    {

        return $this->update([
          'email' => $email,
        ]);
    }

    /**
     * Sets naam on the User model.
     *
     * @param string $naam
     *  The naam to set on the model.
     * @return bool
     *  Returns TRUE if update of the field succeeded, FALSE if $email is empty OR update failed.
     */
    public function setNaam($naam)
    {

        return $this->update([
          'naam' => $naam
        ]);
    }

}