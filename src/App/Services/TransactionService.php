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

        unset($_SESSION['transactionsCount']);
    }

    public function getAmountByUser($userId)
    {
        return $this->db->query(
            "SELECT SUM(amount) FROM transactions WHERE user_id = :userId",
            ['userId' => $userId]
        )->first();
    }

    public function getByUser(string $searchTerm, int $length, int $offset)
    {
        // The LIMIT and OFFSET clauses are not support placeholders only strings, make sure it's provided by you and not by the user
        return $this->db->query(
            "SELECT *,
            DATE_FORMAT(date, '%d-%m-%Y') as formatted_date
            FROM transactions WHERE user_id = :userId
            AND description LIKE :searchTerm
            LIMIT {$length} OFFSET {$offset}",
            [
                'userId' => $_SESSION['user'],
                'searchTerm' => "%{$searchTerm}%"
            ]
        )->all();
    }

    public function getCountByUser(string $searchTerm)
    {
        return $this->db->query(
            "SELECT COUNT(*) FROM transactions
             WHERE user_id = :userId
             AND description LIKE :searchTerm",
            [
                'userId' => $_SESSION['user'],
                'searchTerm' => "%{$searchTerm}%"
            ]
        )->count();
    }

    public function getOneByUser(string $transactionId)
    {
        return $this->db->query(
            "SELECT *,
            DATE_FORMAT(date, '%Y-%m-%d') as formatted_date
            FROM transactions WHERE user_id = :userId AND id = :id",
            [
                'userId' => $_SESSION['user'],
                'id' => $transactionId
            ]
        )->first();
    }

    public function update(string $transactionId, array $data)
    {
        extract($data);
        $formattedDate = "{$date} 00:00:00";
        $this->db->query(
            "UPDATE transactions SET amount = :amount, description = :description, date = :date WHERE user_id = :user_id AND id = :id",
            [
                'amount' => $amount,
                'description' => $description,
                'date' => $formattedDate,
                'user_id' => $_SESSION['user'],
                'id' => $transactionId
            ]
        );
    }
}