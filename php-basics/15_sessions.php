<?php

session_start();

echo "Request Method: ". $_SERVER['REQUEST_METHOD']."<br>";

// Handle POST request
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // Store data in session
    $_SESSION['message'] = $_POST['message'];
    
    // Redirect after POST
    header("Location: 15_sessions.php");
    exit;
 }

 echo "This is GET request. <br>";

 if(isset($_SESSION['message'])){
    echo "Session Message: ".htmlspecialchars($_SESSION['message'])."<br>";
 }else{
    echo "No message stored in session.<br>";
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sessions</title>
</head>
<body>
    <h3> PHP Sessions Example </h3>
    <form method="post">
        <input type="text" name="message" placeholder="Type something">
        <button type="submit">Submit</button>
    </form>
    
    <form method = "post" action="?clear=1" style = "margin-top:20px;">
        <button type="submit" name="clear_session">Clear Session</button>
</body>
</html>

<?php
// Clear session data if requested
if(isset($_GET['clear'])){
    session_destroy();
}