<?php

require_once __DIR__ . '/02_pdo_connection.php';

session_start();

// Authentication helper functions

// Gatekeeper function to protect pages
function requireAuth(){
    if(!isset($_SESSION['user_id'])){
        die('Access denied. Please log in.');
    }
}

// Fetch the currently logged-in user
function currentUser(){
    if(!isset($_SESSION['user_id'])){
        return null;
    }

    global $pdo;

    $sql = "SELECT id, name, email FROM users WHERE id =:id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'id' => $_SESSION['user_id']
    ]);

    return $stmt->fetch();
}