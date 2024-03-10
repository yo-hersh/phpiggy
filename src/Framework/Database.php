<?php

declare(strict_types=1);

namespace Framework;

use PDO, PDOException, PDOStatement;

class Database
{
    public PDO $connection;
    public PDOStatement $stmt;

    public function __construct(string $driver, array $config, string $username, string $password)
    {

        $config = http_build_query(data: $config,  arg_separator: ';');

        $dsn = "{$driver}:{$config}";

        try {
            $this->connection = new PDO($dsn, $username, $password);
        } catch (PDOException $e) {
            die('Connection failed');
        }
    }

    // It's return the Database class itself to use the different methods like count() in the class which is used to get the count
    public function query(string $query, array $params = []): Database
    {
        $this->stmt = $this->connection->prepare($query);
        $this->stmt->execute($params);
        return $this;
    }

    public function count()
    {
        return $this->stmt->fetchColumn();
    }

    public function first()
    {
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function all()
    {
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
