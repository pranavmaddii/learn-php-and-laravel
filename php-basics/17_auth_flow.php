<?php

session_start();

// Hardcoded user credentials (in a real application, use a database)

$users = [
    'username' => 'admin',
    'password' => password_hash('password123', PASSWORD_DEFAULT)
];

// Handle logout

if(isset($_GET['logout'])){
    session_destroy();
    header("Location: 17_auth_flow.php");
    exit;
}

// Handle login (POST request)

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Verify credentials
    if($username !== $users['username']){
        $_SESSION['error'] = 'Invalid username.';
        header("Location: 17_auth_flow.php");
        exit;
    }

    // Verify password
    if(!password_verify($password, $users['password'])){
        $_SESSION['error'] = 'Invalid password.';
        header("Location: 17_auth_flow.php");
        exit;
    }

    $_SESSION['username'] = $username;
    header("Location: 17_auth_flow.php");
    exit;
}

// GET Request - render page

$error  = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication Flow Demo</title>
</head>
<body>
    <H3>Authentication Flow.</H3>
    <?php if($error): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if(isset($_SESSION['username'])): ?>
        <p> Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
        <a href="?logout=1">Logout</a>
    <?php else: ?>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required>
            <br>
            <input type="password" name="password" placeholder="Password" required>
            <br>
            <button type="submit">Login</button>
        </form>
    <?php endif; ?>
</body>
</html>
