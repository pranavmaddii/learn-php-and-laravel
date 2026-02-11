<?php

/*
========================================
PDO DATABASE CONNECTION
========================================
This file is responsible ONLY for:
- Connecting PHP to MySQL using PDO
- Failing loudly if something is wrong

No queries.
No auth.
No HTML.
========================================
*/

// 1) Database credentials

$host = 'localhost';
$dbname = 'auth_demo';
$username = 'root'; // change if needed
$password = ''; // change if needed

// 2) Data Source Name (DSN)
// This tells PDO which driver and database to use

$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4;";

// 3) PDO options
$options = [
    // Throw exceptions on errors
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,

    // Fetch associative arrays by default
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,

    // Use real prepared statements (security)
    PDO::ATTR_EMULATE_PREPARES => false,
];

// 4) Create PDO instance (open connection)
try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    // Stop execution immediately if connection fails
    die('Database connection failed: ' . $e->getMessage());
}

// 5) Connection test (temporary)
// echo "PDO connection successful";