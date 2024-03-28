<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Validator;
use Framework\Rules\{
    DateFormatRule,
    RequiredRule,
    EmailRules,
    MinRule,
    InRule,
    UrlRule,
    MatchRule,
    LengthMaxRule,
    NumericRule
};

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
        $this->validator->addRule('lengthMax', new LengthMaxRule());
        $this->validator->addRule('numeric', new NumericRule());
        $this->validator->addRule('dateFormat', new DateFormatRule());
    }

    public function validateRegister(array $formData)
    {
        $this->validator->validate($formData, [
            'email' => ['required', 'email'],
            'age' => ['required', 'numeric', 'min:18'],
            'country' => ['required', 'in:USA,Canada,Mexico'],
            'social_media_url' => ['required', 'url'],
            'password' => ['required'],
            'confirm_password' => ['required', 'match:password'],
            'tos' => ['required']
        ]);
    }

    public function validateLogin(array $formData)
    {
        $this->validator->validate($formData, [
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
    }

    public function validateCreateTransaction(array $formData)
    {
        $this->validator->validate($formData, [
            'amount' => ['required', 'numeric', 'min:0.1'],
            'description' => ['required', 'lengthMax:255'],
            'date' => ['required', 'dateFormat:Y-m-d'],
        ]);
    }
}
