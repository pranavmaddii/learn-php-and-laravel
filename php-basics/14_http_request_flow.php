<?php

echo "Request Method: ". $_SERVER['REQUEST_METHOD']."<br>";
echo "Request URI: ". $_SERVER['REQUEST_URI']. "<br>";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    echo "This is POST request.<br>";
    echo "Post Data Recieved. <br>";
    var_dump($_POST);

    echo "<br>Redirecting after POST...<br>";
    header("Location: 14_http_request_flow.php");
    exit;
}

echo "This is GET request.<br>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTTP Request Flow</title>
</head>
<body>
    <h3>HTTP Request Flow Demo</h3>
    <form method = "post">
        <input type = "text" name="message" placeholder="Type something">
        <button type="submit">Submit</button>  
    </form>
</body>
</html>