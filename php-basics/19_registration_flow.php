<?php
session_start();

// Initialize users array in session if not already set
if(!isset($_SESSION['users'])){
    $_SESSION['users'] = [];
}

// Handle registration (POST request)
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = trim($_POST['username']?? '');
    $password = $_POST['password']?? '';

    // Basic validation
    if($username === '' || $password === ''){
        $_SESSION['error'] = 'Username and password are required.';
        header("Location: 19_registration_flow.php");
        exit;
    }

    // Check if username already exists
    if(isset($_SESSION['users'][$username])){
        $_SESSION['error'] = 'Username already taken.';
        header("Location: 19_registration_flow.php");
        exit;
    }

    // Hash the password and store the user
    $hashPassword = password_hash($password, PASSWORD_DEFAULT);

    //Store user in session array
    $_SESSION['users'][$username] = $hashPassword;
    $_SESSION['success'] = 'Registration successful! You can now log in.';
    header("Location: 19_registration_flow.php");
    exit;
}

// GET Request - render page

$error  = $_SESSION['error'] ?? '';
$success = $_SESSION['success'] ?? '';

unset($_SESSION['error'], $_SESSION['success']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Flow</title>
</head>
<body>
    <h1> User Registration</h1>
    <?php if($error): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <?php if($success): ?>
        <p style="color:green;"><?php echo htmlspecialchars($success); ?></p> 
    <?php endif; ?>

    <form method = "POST">
        <label> Username:</label><br>
        <input type = "text" name="username" required><br><br>
        <label> Password:</label><br>   
        <input type = "password" name="password" required><br><br>
        <button type="submit"> Register</button>
    </form>
</body>
</html>