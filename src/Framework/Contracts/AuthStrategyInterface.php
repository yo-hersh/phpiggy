<?php

namespace Framework\Contracts;

interface AuthStrategyInterface
{
    public function authenticate(array $credentials): bool;
    public function getPermissions(array $credentials): array;
}
