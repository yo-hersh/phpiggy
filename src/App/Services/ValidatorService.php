<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Validator;
use Framework\Rules\{RequiredRule, EmailRules, MinRule};

class ValidatorService
{
    private Validator $validator;

    public function __construct()
    {
        $this->validator = new Validator();
        $this->validator->addRule('required', new RequiredRule());
        $this->validator->addRule('email', new EmailRules());
        $this->validator->addRule('min', new MinRule());
    }

    public function validateRegister(array $formData)
    {
        $this->validator->validate($formData, [
            'email' => ['required', 'email'],
            'age' => ['required', 'min:18'],
            'country' => ['required'],
            'social_media_url' => ['required'],
            'password' => ['required'],
            'confirm_password' => ['required'],
            'tos' => ['required']
        ]);
    }
}
