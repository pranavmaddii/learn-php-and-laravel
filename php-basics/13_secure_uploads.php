<?php

/**
 * 13_secure_file_uploads.php
 *
 * Covers:
 * - Upload error handling
 * - File size validation
 * - MIME type validation (server-side)
 * - Extension validation
 * - Blocking executable files
 * - Secure file renaming
 * - Safe upload directory handling
 * - Optional image integrity check
 */

$MAX_FILE_SIZE = 2 * 1024 *1024; // 2 MB

// Allowed MIME types (trusted list)

$ALLOWED_MIME_TYPES = [
    "image/jpeg",
    "image/png",
    "application/pdf"
];

// Allowed file extensions

$ALLOWED_EXTENSIONS = [
    "jpg",
    "jpeg",
    "png",
    "pdf"
];

// Explicitly blocked extensions

$BLOCKED_EXTENSIONS = [
    "php",
    "phtml",
    "php3",
    "php4",
    "php5",
];

// Upload directory (relative to this file)

$UPLOAD_DIR = __DIR__."/uploads/";

// Request Validation

if($_SERVER["REQUEST_METHOD"] !== "POST"){
    die("Invalid request method.");
}
if(!isset($_FILES["uploadedFile"])){
    die("No file uploaded.");
}

$file = $_FILES["uploadedFile"];

// Upload Error Handling

if($file["error"] !== UPLOAD_ERR_OK){
    die("Upload error code: " . $file["error"]);
}

// File Size Validation

if ($file['size'] === 0) {
    die('Empty file uploaded');
}
if($file["size"] >$MAX_FILE_SIZE){
    die("File exceeds maximum allowed size of 2 MB.");
}

// Extension Validation

$originalName = $file["name"];
$extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

if($extension === ""){
    die("File must have an extension.");
}
if(in_array($extension, $BLOCKED_EXTENSIONS, true)){
    die("Files with the .$extension extension are not allowed.");
}

if(!in_array($extension, $ALLOWED_EXTENSIONS, true)){
    die("Files with the .$extension extension are not allowed.");
}

// MIME Type Validation

$finfo = finfo_open(FILEINFO_MIME_TYPE);
if($finfo === false){
    die("Failed to open fileinfo.");
}

$mimeType = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);

if ($mimeType === false) {
    die('Could not determine MIME type');
}

if (!in_array($mimeType, $ALLOWED_MIME_TYPES, true)) {
    die('Invalid MIME type detected');
}

// Upload Directory Handling

if (!is_dir($UPLOAD_DIR)) {
    if (!mkdir($UPLOAD_DIR, 0755, true)) {
        die('Failed to create upload directory');
    }
}

// Safe file renaming

// Cryptographically secure random filename
try {
    $safeFileName = bin2hex(random_bytes(16)) . '.' . $extension;
} catch (Exception $e) {
    die('Failed to generate secure filename');
}

$destinationPath = $UPLOAD_DIR . $safeFileName;

// Move uploaded file

if (!move_uploaded_file($file['tmp_name'], $destinationPath)) {
    die('Failed to move uploaded file');
}

// Success response

echo "Upload successful\n";
echo "Stored as: " . htmlspecialchars($safeFileName, ENT_QUOTES, 'UTF-8');