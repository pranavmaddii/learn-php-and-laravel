<?php

echo "Basic Function: \n";

function sayHello(){
    echo "Hello World!". PHP_EOL;
}

sayHello();
sayHello();

echo PHP_EOL;

echo "Function with Parameter: \n";

function greet($name){
    echo "Hello, ". $name . "!".PHP_EOL;
}

greet("Dexter");
greet("Alice");

echo PHP_EOL;

echo "Function with multiple parameters: \n";  

function add($a, $b){
    echo "Sum: ". ($a+$b). PHP_EOL;
}

add(2,3);
add(1000,1.34);

echo PHP_EOL;

echo "Function with default parameter; \n";

function introduce($name = "Guest"){
    echo "Welcome, ". $name . "!".PHP_EOL;
}

introduce("Dexter");
introduce();

echo PHP_EOL;

echo "Function used inside Loop: \n";   

function printUser($user){
    echo $user["name"] . " is " . $user["age"] . " years old.". PHP_EOL;
}

$users = [
    ["name" => "Alice", "age" => 25],
    ["name" => "Bob", "age" => 28],
    ["name" => "Charlie", "age" => 22]
];

foreach($users as $user){
    printUser($user);
}

echo PHP_EOL;

echo "Function Debugging Example: \n";

function debug($data){
    var_dump($data);
}

debug(["php", "laravel", "git"]);
debug(22.5);
debug(true);
debug(null);