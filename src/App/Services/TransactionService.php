<?php

namespace App\Services;

use Framework\Database;

class TransactionService
{
    public function __construct(private Database $db)
    {
    }

    public function create(array $data)
    {
        extract($data);
        $this->db->query(
            "INSERT INTO transactions (user_id, amount, description, date) VALUES (:user_id, :amount, :description, :date)",
            [
                'user_id' => $_SESSION['user'],
                'amount' => $amount,
                'description' => $description,
                'date' => $data
            ]
        );
    }

    public function getAmountByUser($userId)
    {
        return $this->db->query(
            "SELECT SUM(amount) FROM transactions WHERE user_id = :userId",
            ['userId' => $userId]
        )->first();
    }

}