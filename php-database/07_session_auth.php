<?php

require_once __DIR__ .'/02_pdo_connection.php';

session_start();

// Session-based authentication

$email = 'bob@gmail.com';
$password = 'bobsmith';

// Fetch user from database
$sql = "SELECT id, password FROM users where email = :email";
$stmt = $pdo->prepare($sql);
$stmt -> execute([
    'email' => $email
]);

$user = $stmt->fetch();
if(!$user){
    die('User not found');
}

// Verify password
if(!password_verify($password, $user['password'])){
    die('Invalid password');
}

// Regenerate session ID to prevent session fixation attacks
session_regenerate_id(true);

// Store user information in session
$_SESSION['user_id'] = $user['id'];

// echo "User logged in with ID: " . $_SESSION['user_id'];

// echo "<br><br>Logging out...";

// session_unset();    // clear session variables
// session_destroy(); // destroy session

// echo "<br>Logged out";
