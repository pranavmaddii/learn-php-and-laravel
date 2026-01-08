<?php

$i = 1;
echo "While Loop Example:\n";
while ($i <= 10){
    echo "Number: " .$i . PHP_EOL;
    $i++; 
}

echo "\n";
echo "For Loop Example:\n";

for($i = 2; $i<=3; $i++){
    echo "Number: " .$i . PHP_EOL;
}

echo PHP_EOL;
echo "Foreach Loop Example:\n";

$colors = ["Blue", "Red", "Black", "White"];
foreach($colors as $color){
    echo $color. PHP_EOL;
}

echo PHP_EOL;
echo "Foreach With Index:\n";

foreach($colors as $index => $color){
    echo $index . "=>". $color. PHP_EOL;
}

echo PHP_EOL;
echo "Associative Array Foreach:\n";

$user = [
    "name" => "Dexter",
    "age" => 30,
    "email" => "dexter@example.com"
];

foreach($user as $key => $value){
    echo $key . " : " . $value . PHP_EOL;
}

echo PHP_EOL;
echo "Nested Array Loop:\n";

$users = [
    ["name" => "Alice", "age" => 25],
    ["name" => "Bob", "age" => 28]
];

foreach($users as $user){
    echo $user["name"]. ":". $user["age"]. PHP_EOL;
}

echo PHP_EOL;

echo "Break and Continue Example:\n";

for($i = 1; $i <= 10; $i++){
    if($i == 5){
        echo "Skipping number 5\n";
        continue; // Skip number 5
    }
    if($i == 8){
        echo "Breaking at number 8\n";
        break; // Stop the loop at number 8
    }
    echo "Number: " . $i . PHP_EOL;
}
echo PHP_EOL;

echo "Debugging inside loops: ".PHP_EOL;
foreach($users as $index => $user){
    echo "Index: $index".PHP_EOL;
    var_dump($user);
}