<?php

$age = 21;
$city = "Hyderabad";


// if-else

if($age >= 18){
    echo "Adult\n";
}
else{
    echo "Minor\n";
}

// else-if

if($city == "Hyderabad"){
    echo "You are from Hyderabad\n";
}
elseif($city == "Chennai"){
    echo "Ypu are from Chennai\n";
}
else{
    echo "City not identified\n";
}

// Logical operators
$isDev = true;

if($age >= 18 && $isDev){
    echo "Adult Dev\n";
}