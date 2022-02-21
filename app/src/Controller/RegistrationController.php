<?php

namespace App\Controller;

use App\Form\ValidatedAliasField;
use App\Form\ValidatedEmailField;
use App\Form\ValidatedPasswordField;
use SilverStripe\CMS\Controllers\ContentController;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Security\Member;

class RegistrationController extends ContentController
{
    private static $allowed_actions = [
        'registerForm'
    ];

    public function registerForm(): Form
    {
        $fields = new FieldList(
            ValidatedAliasField::create('alias','Alias')->addExtraClass('test'),
            ValidatedEmailField::create('email','Email'),
            ValidatedPasswordField::create('password','Password'),
        );

        $actions = new FieldList(
            FormAction::create(
                'doRegister',
                'Register'
            )
        );

        $required = new RequiredFields('alias','email','password');

        return new Form($this, 'RegisterForm', $fields, $actions, $required);
    }

    public function doRegister(array $data, Form $form): \SilverStripe\Control\HTTPResponse
    {
        // Make sure we have all the data we need
        $alias = $data['alias'] ?? null;
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        /*
         * Check if the fields clear their validation rules.
         * If there are errors, then the form will be updated with the errors
         * so the user may correct them.
         */
        $validationResults = $form->validationResult();

        if ($validationResults->isValid()) {
            $member = Member::create();
            $member->FirstName = $alias;
            $member->Email = $email;
            $member->Password = $password;
            $member->write();

            // HERE IS OUR UPDATE 👇
            $member->addToGroupByCode("reviewers");
            $member->write();

            $form->sessionMessage('Registration successful', 'good');
        }

        return $this->redirectBack();
    }
}
