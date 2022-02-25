<?php

namespace App\Page;

use App\Controller\RegistrationController;
use Page;

class RegistrationPage extends Page
{
    public function getControllerName(): string
    {
        return RegistrationController::class;
    }
}
