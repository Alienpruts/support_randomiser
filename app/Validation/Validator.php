<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 11/2/16
 * Time: 5:14 PM
 */

namespace Alienpruts\SupportRandomiser\Validation;


use Respect\Validation\Exceptions\NestedValidationException;
use Slim\Http\Request;

class Validator
{

    protected $errors;

    public function validate(Request $req, array $rules)
    {
        foreach ($rules as $field => $rule) {
            try {
                $rule->setName(ucfirst($field))->assert($req->getParam($field));
            } catch (NestedValidationException $e) {
                $this->errors[$field] = $e->getMessages();
            }
        }

        // Set errors in session.
        $_SESSION['errors'] = $this->errors;

        return $this;
    }

    public function failed()
    {
        return !empty($this->errors);
    }
}