<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;

class EmailRules implements RuleInterface
{
    public function validate(array $data, string $field, array $params): bool
    {
        return (bool)filter_var($data[$field], FILTER_VALIDATE_EMAIL);
    }

    public function getErrorMessage(array $data, string $field, array $params): string
    {
        return "Field {$field} is not a valid email";
    }
}
