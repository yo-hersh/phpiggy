<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;

class RequiredRule implements RuleInterface
{
    public function validate(array $data, string $field, array $params): bool
    {
        return !empty($data[$field]);
    }
    public function getErrorMessage(array $data, string $field, array $params): string
    {
        return "Field {$field} is required";
    }
}
