<?php

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;
use InvalidArgumentException;

class LengthMaxRule implements RuleInterface
{
    public function validate($data, $field, $params): bool
    {
        if (empty ($params[0])) {
            throw new InvalidArgumentException("Max length rule requires a parameter");
        }
        return strlen($data[$field]) < (int) $params[0];
    }

    public function getErrorMessage(array $data, string $field, array $params): string
    {
        return "The {$field} must be less than {$params[0]} characters";
    }
}