<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;
use Firebase;

class AuthServices
{
    public function __construct(private Database $db)
    {
    }

    public function createJwt(array $user)
    {
        $payload = [
            'id' => $user['id'],
            'email' => $user['email'],
            'iat' => time(),
            'exp' => time() + 3600,
            'role' => $user['role']
        ];

        return Firebase\JWT\JWT::encode($payload, $_ENV['JWT_SECRET'], 'HS256');
    }
}
