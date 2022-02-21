<?php

namespace App\Form;

use SilverStripe\Forms\TextField;
use SilverStripe\Security\Member;

class ValidatedPasswordField extends TextField
{
    public function validate($validator)
    {
        $value = $this->Value();
        if(strlen($value) < 6) {
            $validator->validationError(
                $this->name,
                'Password must be at least 6 characters long',
                'validation'
            );
            return false;
        }
        return true;
    }
}
