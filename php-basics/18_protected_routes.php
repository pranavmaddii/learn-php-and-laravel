<?php

session_start();

// Check if the user is logged in
if(!isset($_SESSION['username'])){
    // Redirect to the login page if not logged in
    header("Location: 17_auth_flow.php");
    exit;
}

// User is logged in, display protected content
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Protected Dashboard</title>
</head>
<body>
    <p> Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>! You have accessed a protected route.</p>
    <p> This page is only visible to authenticated users.</p>
    <a href="17_auth_flow.php?logout=1">Logout</a>
    
</body>
</html>