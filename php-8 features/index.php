<?php
// goto ConstantsInTraits;
// goto Enums
// goto ReadonlyPropertiesAndClasses
// goto Fibers
// goto Closures
// goto ClosuresInLaravel
// goto MethodsChaining
// goto DependencyInjection

DependencyInjection:
// Dependency Injection

// 1. A class with some functionality
class Logger{
    public function log($message){
        echo "Logging: $message";
    }
}

// 2. Create a class that needs the Logger (the dependent class)
class UserService{
    private $logger;

    // Logger is injected through the constructor
    public function __construct(Logger $logger){
        $this->logger = $logger;
    }

    public function createUser($name){
        $this->logger->log("Creating user: $name<br>");
        return "User $name created!<br>";
    }
}

$logger = new Logger(); // Create the dependency
$userService = new UserService($logger); // Inject it
echo $userService->createUser("Dexter");

return;
class Service{
    public function doSomething(){
        return "Service is doing something.";
    }
}

class FacadeForService{
    public static function __callStatic($method, $args){
        return (new Service())->$method(...$args);
    }
}

echo FacadeForService::doSomething();
return;
MethodsChaining:
// Methods Chaining

response()->json(['name' => 'Bob', 'age' => 30]);
response2()->json(['name' => 'Bob', 'age' => 30])->send();

function response(){
    return new class{
        public function json($data){
            header('Content-type: application/json');
            echo json_encode($data);
        }
    };
}

function response2(){
    return new class{
        public $data;
        public function json($data){
            $this->data = $data;
            return $this;
        }

        public function send(){
            header('Content-type: application/json');
            echo json_encode($this->data);
        }
    };
}
return;
ClosuresInLaravel:
// Closures in Laravel
class Router{
    protected $routes =[];

    public function get($path, Closure $action){
        $this-> routes[$path] = $action;
    }

    public function simulateRequest($path){
        if(isset($this->routes[$path])){
            $action = $this->routes[$path];
            echo $action();
        }else{
            echo "404 Not Found<br>";
        }
    }
}

$router = new Router();

$router->get('/hello', function() {
    return "Hello, World!<br>";
});

$router ->simulateRequest('/hello');

return;
Closures:
// closures
$fn = function(){
    return 'result';
};

$fn2 = fn() => 'result<br>';
echo $fn2();

function operate($item, $callback = null){
    if($callback) return $callback($item);
    $item = $item * 2;
    return $item;
}

echo operate(10, fn($item) => $item * 3);

return;
Fibers:
// Fibers

$fiber = new Fiber(function(){
    echo 'Fiber Started<br>';
    $value = Fiber::suspend("Suspending..");
    echo "Fiber resumed with: $value<br>";
});

echo "Starting Fiber...<br>";
$value = $fiber->start(); // Starts the fiber, execution pauses at suspend()
echo "Fiber suspended, returned value: $value<br>";
$fiber->resume("Hello from resume!");
echo "Fiber has completed<br>";

function asyncTask(): Fiber{
    return new Fiber(function(){
        echo "Doing async work.. <br>";
        Fiber::suspend(); //Pause here
        echo "Resuming work..<br>";
    });
}

$fiber = asyncTask();
$fiber->start();
echo "Doing another async task.<br>";
$fiber->resume();

// Make API calls with rate limiting
$apiCaller = new Fiber(function(){
    $queries = ['products', 'users', 'orders'];
    foreach ($queries as $query){
        echo "Fetched $query data<br>";
        Fiber::suspend(); //Pause to respect rate limit
    }
    return "All API calls done!";
});

$apiCaller -> start();
while(!$apiCaller->isTerminated()){
    echo "other operation <br>";
    $apiCaller -> resume();
}
echo $apiCaller->getReturn();
return;
ReadonlyPropertiesAndClasses:
// Readonly Properties and classes
class User2{
    public function __construct(
        public readonly string $name, 
        public readonly string $email
    ){}
}

$user = new User2('Bob', 'bob@example.com');
// $user -> name = 'Alice';

return;

Enums:
// Enums
enum Status: string{
    case Draft = 'draft';
    case Published = 'published';
    case Archived = 'archived';
}

function getStatusMessage(Status $status): string{
    return match($status){
        Status::Draft => 'The status is draft.',
        Status::Published => 'The status is published.',
        Status::Archived => 'The status is Archived.'
    };
}

$status = Status::Archived;
echo getStatusMessage($status);

return;
ConstantsInTraits: 
// Constants in Traits
trait ExampleTrait{
    public const EXAMPLE = 'example';
}

class MyClass2{
    use ExampleTrait;
}

echo MyClass2::EXAMPLE;
return;
// Attributes (Annotations)

#[Attribute]
class Example{
    public function __construct(public string $desc){

    }
}


#[Example("This is an example class")]
class MyClass{
    #[Example("This is an example method")]
    public function myMethod(){}
}

// $attr = (new ReflectionClass(MyClass::class))
//     -> getAttributes(Example::class)[0]
//     -> newInstance();

$attr = (new ReflectionMethod(MyClass::class, 'myMethod'))
    -> getAttributes(Example::class)[0]
    -> newInstance();

var_dump($attr->desc);


return;
// php 8 functions

echo str_contains('some huge sentece bla bla', 'bla');
echo str_starts_with('some huge sentece bla bla', 'some');
echo str_ends_with('some huge sentece bla bla', 'bla');
$a = array_fill(-5, 4, 'aaa');
var_dump($a);
echo "<br>";

// Weak Maps

// A WeakMap allows you to associate data with an object without preventing that object from being garbage collected.
$metadata = new WeakMap();
// Create an object
$user = new class('John'){
    public function __construct(public $name){}
};

// Store metadata associated with the object
$metadata[$user] = ['created_at' => date('Y-m-d'), 'access_count'=> 0];

// Access the metadata
echo "User created at: ".$metadata[$user]['created_at']. "<br>";

// Increment access count
$metadata[$user]['access_count']++;

echo "Access count: ".$metadata[$user]['access_count']. "<br>";
echo "Metadata Entries: ". count($metadata). "<br>";

// When the object is destroyed...

unset($user);

// The metadata is automatically cleaned up
echo "Metadata Entries: ". count($metadata). "<br>"; // Output:0



return;
// Intersection types

function process((Countable & Iterator) | string $input){
    if(is_string($input)){
        echo "String: $input";
    }else{
        echo "Count: ".$input->count()."\n";
    }
}
process("hello");
return;
// Union Types

class UnionTypeExample{
    public function foo(string | int | array |float $arg): string | int | array | float {
        return $arg  * 2;
        return $arg;
    }
}

// print_r((new UnionTypeExample)->foo([1,2,3])); // This will cause a TypeError
print_r((new UnionTypeExample)->foo(2.52));
return;
// Constructor Property Promotion

class PromotedUser{
    public function __construct(
        public string $name,
        public int $age,
    ){}
}

// Without promotion:
// class PromotedUser{
//     public $name;
//     public $age;
//     public function __construct($name, $age){
//         $this->name = $name;
//         $this->age = $age;
//     }
// }

$user = new PromotedUser('Alice', 25);
echo "Name: {$user->name}, Age: {$user->age}";

return;
// Nullsafe Operator

class NullsafeUser{
    public function address(){
        // return new Address();
        return null;
    }
}
class Address{
    public function country(){
        return 'USA';
    }
}
$user = new NullsafeUser();
echo $user?->address()?->country()?? 'homeless';

return;
// Named Arguments

function person($name, $lastName, $age, $address=null, $bio = null){
    echo "Hello $name $lastName  you are $age years old.";
    if($address) echo "you live in $address";
    if($bio) echo " <br>Bio: $bio";
}

// person('Dexter', 'Morgan', 30, null, 'I am a software developer.');
person(name: 'Sarah', lastName: 'Connor', age: 35);

class A{
    public function __construct($name, $age)
    {
        echo "<br> Hello $name, you are $age years old.";
    }
}
new A(age: 28, name: 'Kyle');

return;
// Match Expression

$name = 'John';
$message = match($name){
    'John' => 'Hello John',
    'Jane' => 'Hello Jane',
    default => 'Hello Guest',
};
echo $message;