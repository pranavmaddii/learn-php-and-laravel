<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method = POST enctype="multipart/form-data">
        <label> Select a file to upload:</label>
        <input type = "file" name = "uploadedFile">
        <br><br>
        <button type="submit">Upload File</button>    
    </form>
</body>
</html>

<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!isset($_FILES["uploadedFile"])) {
        echo "No file uploaded.";
        exit;
    }

    $file = $_FILES["uploadedFile"];

    if ($file["error"] !== 0) {
        echo "Upload error occurred.";
        exit;
    }

    $uploadDir = "uploads/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir);
    }

    $filename = basename($file["name"]);
    $destination = $uploadDir . $filename;

    if (move_uploaded_file($file["tmp_name"], $destination)) {
        echo "File uploaded to: " . $destination;
    } else {
        echo "Failed to move uploaded file.";
    }
}

?>

