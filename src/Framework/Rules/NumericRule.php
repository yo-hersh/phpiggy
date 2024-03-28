<?php

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;

class NumericRule implements RuleInterface
{
    public function validate($data, $field, $params): bool
    {
        return is_numeric($data[$field]);
    }

    public function getErrorMessage(array $data, string $field, array $params): string
    {
        return "Field {$field} must be numeric";
    }
}