<?php

require_once __DIR__ . '/auth.php';

//Enforce authentication
requireAuth();

$user = currentUser();

echo "Welcome to the protected page, " . htmlspecialchars($user['name']) . "!";