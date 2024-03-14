<?php

namespace App\Auth;

use Framework\Contracts\AuthStrategyInterface;

class JwtStrategy implements AuthStrategyInterface
{
    public function authenticate(array $credentials): bool
    {

        return true;
    }

    public function getPermissions(array $credentials): array
    {
        // Return permissions from token directly
        $token = $credentials['token'] ?? '';
        $jwtParts = explode('.', $token);
        $payload = base64_decode(str_pad(strtr($jwtParts[1], '-_', '+/'), strlen($jwtParts[1]) % 4, '='));
        $data = json_decode($payload, true);

        return $data['permissions'] ?? [''];
    }

    public function createToken(array $user): string
    {
        $secret = $_ENV['JWT_SECRET'] ?? 'your-secret*2';
        $payload = json_encode(['permissions' => $user['permissions'] ?? []]);
        $data = $payload . '.' . base64_encode(hash_hmac('sha256', $payload, $secret, true));

        return $data;
    }
}
