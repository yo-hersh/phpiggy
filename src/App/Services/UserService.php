<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;
use Framework\Exceptions\ValidationException;

class UserService
{
    public function __construct(private Database $db)
    {
    }

    public function isEmailTaken(string $email)
    {
        $emailCount = $this->db->query(
            "SELECT COUNT(*) FROM users WHERE email = :email",
            ['email' => $email]
        )->count();

        if ($emailCount > 0) {
            throw new ValidationException(['email' => ['Email is already taken']], 422);
        }
    }

    public function create(array $data)
    {
        extract($data);
        $this->db->query(
            "INSERT INTO users (email, age, country, social_media_url, password)
             VALUES (:email, :age, :country, :social_media_url, :password)",
            [
                'email' => $email,
                'age' => $age,
                'country' => $country,
                'social_media_url' => $social_media_url,
                'password' => $password
            ]
        );
    }
}
