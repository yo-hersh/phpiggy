<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;
use InvalidArgumentException;

class MinRule implements RuleInterface
{
    public function validate(array $data, string $field, array $params): bool
    {
        if (empty($params[0])) {
            throw new InvalidArgumentException("min rule requires a parameter");
        }
        return $data[$field] >= $params[0];
    }

    public function getErrorMessage(array $data, string $field, array $params): string
    {
        return "Must be at least {$params[0]}";
    }
}
