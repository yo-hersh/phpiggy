<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;

class MatchRule implements RuleInterface
{
    public function validate(array $data, string $field, array $params): bool
    {
        return $data[$field] === $data[$params[0]];
    }
    public function getErrorMessage(array $data, string $field, array $params): string
    {
        return $field . ' must match ' . $params[0];
    }
}
