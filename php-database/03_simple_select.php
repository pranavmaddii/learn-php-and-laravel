<?php

require_once __DIR__ . '/02_pdo_connection.php';

/*
========================================
SIMPLE SELECT QUERY (NO USER INPUT)
========================================
*/

$sql = "SELECT id, name, email FROM test_users";

// query() is SAFE here because:
// - SQL is static
// - No user input

$stmt = $pdo->query($sql);

// Fetch all rows
$users = $stmt->fetchAll();

// Inspect the results
echo '<pre>';
print_r($users);
echo '</pre>';