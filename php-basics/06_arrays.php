<?php

// Indexed Array
$fruits = ["Apple", "Banana", "Orange"];
echo $fruits[0]. "\n\n";

// Associative Array
$user = [
    "name" => "Dexter",
    "age" => 22,
    "isDev" => true
];

echo $user["name"]."\n";
echo $user["age"]."\n\n";

// Nested Array
$profile = [
    "user" => $user,
    "skills" => ["PHP", "Laravel", "Git"]
];

echo $profile["skills"][1]. "\n\n";

// Debug
print_r($profile);