<?php

session_start();

$users=[
    'admin' => password_hash('admin', PASSWORD_DEFAULT)
];

function isLoggedIn(): bool {
    return isset($_SESSION['username']);
}

function requireAuth():void{
    if(!isLoggedIn()){
        session_destroy();
        header("Location: 20_refactor_auth.php");
        exit;
    }
}

function login(string $username): void {
    session_regenerate_id(true);
    $_SESSION['username'] = $username;
}

function logout(): void {
    session_destroy();
    header("Location: 20_refactor_auth.php");   
    exit;
}

function flashMsg(string $msg): string{
    $value = $_SESSION[$msg] ?? '';
    unset($_SESSION[$msg]);
    return $value;
}

// Handle logout
if(isset($_GET['logout'])){
    logout();
}   

// Handle login (POST request)
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if($username === '' || $password === ''){
        $_SESSION['error'] = 'Username and password are required.';
        header("Location: 20_refactor_auth.php");
        exit;
    }

    if(!isset($users[$username])){
        $_SESSION['error'] = 'Invalid username.';
        header("Location: 20_refactor_auth.php");
        exit;
    }

    if(!password_verify($password, $users[$username])){
        $_SESSION['error'] = 'Invalid password.';
        header("Location: 20_refactor_auth.php");
        exit;
    }

    login($username);
    header("Location: 20_refactor_auth.php");   
    exit;
}

// GET Request - render page

$error  = flashMsg('error');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refactored Auth Flow</title>
</head>
<body>
    <h2> Refactored Authentication Flow </h2>
    <?php if($error):?>
        <p style="color:red;"> <?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if(isLoggedIn()): ?>
        <p> Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
        <p><a href="20_refactor_auth.php?logout=1">Logout</a></p>
    <?php else: ?>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Login</button>
    </form>
    <?php endif; ?>
</body>
</html>