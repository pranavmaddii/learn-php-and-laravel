<?php

// Plain text password
$plainPassword = "secret123";

// Hash the password
$hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

echo "Plain Password: " . $plainPassword . "<br>";
echo "Hashed Password: " . $hashedPassword . "<br>";

// Verify the password login simulation

$loginAttempt = "secret123";

if(password_verify($loginAttempt, $hashedPassword)){
    echo "Password is valid!<br>";
} else {
    echo "Invalid password.<br>";  
}

// Demonstrate with a wrong password

$wrongAttempt = "wrongpassword";

if(password_verify($wrongAttempt, $hashedPassword)){
    echo "Password is valid!<br>";
} else {
    echo "Invalid password.<br>";  
}
