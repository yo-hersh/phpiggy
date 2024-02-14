<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Validator;
use Framework\Rules\{RequiredRule, EmailRules, MinRule, InRule, UrlRule, MatchRule};

class ValidatorService
{
    private Validator $validator;

    public function __construct()
    {
        $this->validator = new Validator();
        $this->validator->addRule('required', new RequiredRule());
        $this->validator->addRule('email', new EmailRules());
        $this->validator->addRule('min', new MinRule());
        $this->validator->addRule('in', new InRule());
        $this->validator->addRule('url', new UrlRule());
        $this->validator->addRule('match', new MatchRule());
    }

    public function validateRegister(array $formData)
    {
        $this->validator->validate($formData, [
            'email' => ['required', 'email'],
            'age' => ['required', 'min:18'],
            'country' => ['required', 'in:USA,Canada,Mexico'],
            'social_media_url' => ['required', 'url'],
            'password' => ['required'],
            'confirm_password' => ['required', 'match:password'],
            'tos' => ['required']
        ]);
    }
}
