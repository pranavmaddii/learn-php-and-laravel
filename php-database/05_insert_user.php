<?php

require_once __DIR__ . '/02_pdo_connection.php';

// Insert user using prepared statements

$name = 'Bob Smith';
$email = 'bob@gmail.com';
$password = 'bobsmith';

// Hash the password before storing it
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
$stmt = $pdo -> prepare($sql);
$stmt->execute([
    'name' => $name,
    'email' => $email,
    'password' => $hashedPassword
]);

$userId = $pdo->lastInsertId();
echo "New user inserted with ID: " . $userId;

