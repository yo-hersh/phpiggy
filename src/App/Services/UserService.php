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
        // d'ont use the default password hashing, if is been changed in the php team, the users will not be able to login
        $password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
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

    public function login(string $email, string $password)
    {

        $user = $this->db->query(
            "SELECT * FROM users WHERE email = :email",
            ['email' => $email]
        )->first();

        if (empty($user) || !password_verify($password, $user['password']  ?? '')) {
            throw new ValidationException(['login' => ['Email / Password invalid']]);
        }

        session_regenerate_id(true);

        $_SESSION['user'] = $user['id'];
        return $user;
    }

    public function logout()
    {
        unset($_SESSION['user']);

        session_regenerate_id();
    }
}
