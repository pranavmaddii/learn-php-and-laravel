<?php

// HTML FORM (POST)

?>
<form method="POST">
    <input name="username">
    <button type="submit">Send</button>
</form>

<?php

// POST HANDLING

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"] ?? "";
    echo $username . PHP_EOL;
}

// SERVER INFORMATION

echo $_SERVER["REQUEST_METHOD"] . PHP_EOL;
echo $_SERVER["PHP_SELF"] . PHP_EOL;

// FUNCTION EXAMPLE

function greet($name) {
    echo "Hello, $name!" . PHP_EOL;
}

// CLI argument for function

$name = $argv[1] ?? "Guest";
greet($name);

// STDIN INPUT (CLI)

echo PHP_EOL . "Dynamic Practice:" . PHP_EOL . PHP_EOL;

echo "Enter your Name: ";
$name = trim(fgets(STDIN));

// CLI ARGUMENT ($argv) + LOOP

if (!isset($argv[1])) {
    echo "Please provide a limit as a command line argument." . PHP_EOL;
    exit;
}

$limit = (int) $argv[1];

echo "Hello! $name, here are the numbers up to $limit:" . PHP_EOL;

for ($i = 1; $i <= $limit; $i++) {
    echo $i . PHP_EOL;
}

// GET PARAMETERS (BROWSER)

var_dump($_GET);

$name = $_GET["name"] ?? "Guest";
$age  = $_GET["age"] ?? "Unknown";

echo $name . PHP_EOL;
echo $age . PHP_EOL;
