<?php

declare(strict_types=1);

namespace Framework;

use Framework\Contracts\RuleInterface;
use Framework\Exceptions\validationException;

class Validator
{
    private array $rules = [];

    public function addRule(string $alias, RuleInterface $rule)
    {
        $this->rules[$alias] = $rule;
    }
    public function validate(array $data, array $fields)
    {
        $errors = [];
        foreach ($fields as $field => $rules) {
            foreach ($rules as $rule) {
                $ruleParameters = [];
                if (str_contains($rule, ':')) {
                    [$rule, $ruleParameters] = explode(':', $rule);
                    $ruleParameters = explode(',', $ruleParameters);
                }

                $ruleValidator = $this->rules[$rule];

                if (!$ruleValidator->validate($data, $field, $ruleParameters)) {
                    $errors[$field][] = $ruleValidator->getErrorMessage($data, $field, $ruleParameters);
                }
            }
        }
        if (count($errors)) {
            throw new validationException($errors);
        }
    }
}
