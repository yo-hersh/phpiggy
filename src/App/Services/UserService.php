<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;
use Framework\Exceptions\ValidationException;
use App\Auth\JwtStrategy;

class UserService
{
    public function __construct(private Database $db, private JwtStrategy $jwtStrategy)
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

        $password = $this->hashPassword($password);
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
        $user = $this->getUserByEmail($email);
        $this->validatePassword($user, $password);
        $this->addTokenToUser($user);

        return $user;
    }

    public function getUserByEmail(string $email)
    {
        $user =  $this->db->query(
            "SELECT * FROM users WHERE email = :email",
            ['email' => $email]
        )->first();

        if (empty($user)) {
            throw new ValidationException(['login' => ['Email / Password invalid']]);
        }
        return $user;
    }

    public function validatePassword(array $user, string $password)
    {
        if (!password_verify($password, $user['password'])) {
            throw new ValidationException(['login' => ['Email / Password invalid']]);
        }
    }

    public function getUserByToken(string $token)
    {
        $user =
            $user = $this->db->query(
                "SELECT * FROM users WHERE token = :token",
                ['token' => $token]
            )->first();

        if (empty($user)) {
            throw new ValidationException(['login' => ['Email / Password invalid']]);
        }

        return $user;
    }

    private function hashPassword(string $password)
    {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    private function addTokenToUser(array $user)
    {
        $user['permissions'] = 'user';
        $token = $this->jwtStrategy->createToken($user);

        header('Authorization: Bearer ' . $token);
    }
}
