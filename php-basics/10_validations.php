<?php

/*
|--------------------------------------------------------------------------
| PART 1: CLI VALIDATION ($argv)
|--------------------------------------------------------------------------
| This part runs ONLY when executed from terminal.
| Example:
| php 10_validations.php 5
*/

if(PHP_SAPI == "cli"){
    // check if argumemnt exists AND is numeric.
    if(!isset($argv[1]) || !is_numeric(($argv[1]))){
        echo "Please provide a numeric argument." . PHP_EOL;
        exit;
    }
    $number = (int) $argv[1];
    echo "CLI Input is accepted: " . $number . PHP_EOL;

    for($i=1; $i <= $number; $i++){
        echo "Number: " . $i . PHP_EOL;
    }
    PHP_EOL;
}

/*
|--------------------------------------------------------------------------
| PART 2: HTML FORM (POST)
|--------------------------------------------------------------------------
| This part works ONLY in browser.
| Start server:
| php -S localhost:8000
| Open:
| http://localhost:8000/10_validations.php
*/
?>

<form method = "POST">
    <label>Username:</label>
    <input type="text" name="username">
    <button type="submit">Submit</button>
</form>

<?php

/*
|--------------------------------------------------------------------------
| PART 3: POST VALIDATION
|--------------------------------------------------------------------------
*/

if($_SERVER["REQUEST_METHOD"] === "POST"){
    // Safely read input
    $username = $_POST["username"] ?? "";

    if(empty($username)){
        echo "Username cannot be empty.". PHP_EOL;
        exit;
    }
    // Length check
    if(strlen($username)<5){
        echo "Username must be at least 5 characters long." . PHP_EOL;
        exit;
    }

    //XSS Prevention
    $safe_username = htmlspecialchars(($username), ENT_QUOTES, "UTF-8");
    echo "Welcome, $safe_username!".PHP_EOL;
}

