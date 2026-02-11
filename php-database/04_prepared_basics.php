<?php

require_once __DIR__ . '/02_pdo_connection.php';

// Prepared statements are used to safely execute SQL queries
// that include user input. They help prevent SQL injection attacks.

$email = 'alice@example.com'; // Example user input

$sql = "SELECT id, name, email FROM test_users WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->execute(
    ['email'=>$email]
);


// Fetch the user
$user = $stmt->fetch();
echo '<pre>';
var_dump($user);
echo '</pre>';