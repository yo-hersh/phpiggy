<?php

declare(strict_types=1);

namespace Framework;

use Framework\Contracts\RuleInterface;

class Validator
{
    private array $rules = [];

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
                    echo $ruleValidator->getErrorMessage($data, $field, []);
                }
            }
        }
    }
}
