<?php

declare(strict_types=1);

namespace Framework;

use Framework\Contracts\RuleInterface;
use Framework\Exceptions\validationException;

class Validator
{
    private array $rules = [];
    private array $errors = [];

    public function addRule(string $alias, RuleInterface $rule)
    {
        $this->rules[$alias] = $rule;
    }
    public function validate(array $data, array $fields)
    {
        foreach ($fields as $field => $rules) {
            foreach ($rules as $rule) {

                $ruleValidator = $this->rules[$rule];

                if (!$ruleValidator->validate($data, $field, [])) {
                    $errors[$field][] = $ruleValidator->getErrorMessage($data, $field, []);
                }
            }
        }
        if (count($errors)) {
            throw new validationException();
        }
    }
}
