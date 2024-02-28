<?php

include __DIR__ . "/src/Framework/Database.php";

use Framework\Database;

$db = new Database('mysql', [
    'host' => 'localhost',
    'port' => 3306,
    'dbname' => 'phpiggy'
], 'root', '');


// sql injection
$injection = 'test OR 1=1--';

// by using the query func we can prevent an injection
// $query = "SELECT * FROM products WHERE name={$injection}";
// $stmt = $db->connection->query($query, PDO::FETCH_ASSOC);
// the PDO:: is only can be used in the query func not in the execute func

/*

// solution 1
$query = "SELECT * FROM products WHERE name=?";

$stmt = $db->connection->prepare($query);

$stmt->execute([
    $injection
]);

// solution 2
$query = "SELECT * FROM products WHERE name=:name";

$stmt = $db->connection->prepare($query);

$stmt->execute([
    'name' => $injection
]);

*/

// or with the bind func
$query = "SELECT * FROM products WHERE name=:name";

$stmt = $db->connection->prepare($query);

$stmt->bindValue(':name', $injection, PDO::PARAM_STR);

$stmt->execute();
var_dump($stmt->fetchAll(PDO::FETCH_OBJ));

// Transaction example
try {
    $db->connection->beginTransaction();

    $stmt = $db->connection->query("SELECT * FROM products");
    $db->connection->query("INSERT INTO products (name, ID) VALUES ('test', 10)");
    var_dump($stmt->fetchAll(PDO::FETCH_OBJ));

    $db->connection->commit();
} catch (Exception $e) {
    if ($db->connection->inTransaction()) {
        $db->connection->rollBack();
    }
    echo 'Transaction failed';
}

echo 'Connection established';
