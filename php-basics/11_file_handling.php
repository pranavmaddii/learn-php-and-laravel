<?php

date_default_timezone_set("Asia/Kolkata");

// Opening a file that exists.
$content = file_get_contents("data.txt");
echo $content;
echo PHP_EOL;

// Trying to open a file that does not exist.
if(file_exists("missing.txt")){
    $missingContent = file_get_contents("missing.txt");
    echo $missingContent;
} else {
    echo "Error: File 'missing.txt' does not exist." . PHP_EOL;
}

// Writing to a file. (Overwrite mode)
$file = fopen("data.txt", "w");
fwrite($file, "New content written to the file." . PHP_EOL);
fclose($file);

echo "File 'data.txt' has been updated." . PHP_EOL;

// Writing to a file. (Append mode)
$file = fopen("data.txt", "a");
fwrite($file, "Appending this line to the file." . PHP_EOL);
fclose($file);

echo "A new line has been appended to 'data.txt'." . PHP_EOL;

// Real-world example: Logging

$log = fopen("log.txt", "a");
$message = "User accessed the file at " . date("Y-m-d H:i:s") . PHP_EOL;
fwrite($log, $message);
fclose($log);

echo "Log entry added to 'log.txt'." . PHP_EOL;