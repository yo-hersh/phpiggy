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
        $formattedDate = "{$date} 00:00:00";
        $this->db->query(
            "INSERT INTO transactions (user_id, amount, description, date) VALUES (:user_id, :amount, :description, :date)",
            [
                'user_id' => $_SESSION['user'],
                'amount' => $amount,
                'description' => $description,
                'date' => $formattedDate
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


    public function getTransactionsByUser()
    {
        $searchTerm = addcslashes($_GET['s'] ?? '', '%_');
        return $this->db->query(
            "SELECT *,
             DATE_FORMAT(date, '%d-%m-%Y') as formatted_date
             FROM transactions WHERE user_id = :userId
             AND description LIKE :searchTerm",
            [
                'userId' => $_SESSION['user'],
                'searchTerm' => "%{$searchTerm}%"
            ]
        )->all();
    }
}