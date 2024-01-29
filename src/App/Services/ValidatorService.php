<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Validator;
use Framework\Rules\{RequiredRule};

class ValidatorService
{
    private Validator $validator;

    public function __construct()
    {
        $this->validator = new Validator();
        $this->validator->addRule('required', new RequiredRule());
    }

    public function validateRegister(array $formData)
    {
        $this->validator->validate($formData);
    }
}
