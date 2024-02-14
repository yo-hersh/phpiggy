<?php

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;
use InvalidArgumentException;

class InRule implements RuleInterface
{
    public function validate(array $data, string $field, array $params): bool
    {
        if (empty($params)) {
            throw new InvalidArgumentException("In rule is required parameters");
        }
        return in_array($data[$field], $params);
    }
    public function getErrorMessage(array $data, string $field, array $params): string
    {
        return "Invalid selection";
    }
}
