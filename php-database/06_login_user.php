<?php

require_once __DIR__ . '/02_pdo_connection.php';

// Login user using DB
$email = 'bob@gmail.com';
$password = 'bobsmith';

$sql = "SELECT id, name, email, password FROM users WHERE email = :email";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    'email' => $email
]);

$user = $stmt->fetch();

// Verify user exists and password is correct
if(!$user){
    die('User not found');
}

// Verify password
if (!password_verify($password, $user['password'])) {
    die('Invalid password');
}

// Successful login
echo "Login successful for user ID: " . $user['id'];



