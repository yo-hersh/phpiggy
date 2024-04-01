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

    public function getTransactionsAndCountByUser(string $searchTerm, int $length, int $offset)
    {
        $transactions = $this->getTransactionsByUser($searchTerm, $length, $offset);
        $count = $this->getTransactionCountByUser($searchTerm);

        return [
            $transactions,
            $count
        ];
    }


    public function getTransactionsByUser(string $searchTerm, int $length, int $offset)
    {
        // The LIMIT and OFFSET clauses are not support placeholders only strings, make sure it's provided by you and not by the user.
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

    public function getTransactionCountByUser(string $searchTerm)
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
}