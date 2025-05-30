<?php
// Encapsulation Example
class BankAccount {
    private $balance;  // Private property
    
    public function deposit($amount) {
        if ($amount > 0) {
            $this->balance += $amount;
            return true;
        }
        return false;
    }
    
    public function getBalance() {
        return $this->balance;
    }
}

// Abstraction Example
abstract class Shape {
    abstract public function calculateArea();
    abstract public function calculatePerimeter();
}

class Rectangle extends Shape {
    private $length;
    private $width;
    
    public function __construct($length, $width) {
        $this->length = $length;
        $this->width = $width;
    }
    
    public function calculateArea() {
        return $this->length * $this->width;
    }
    
    public function calculatePerimeter() {
        return 2 * ($this->length + $this->width);
    }
}

// Inheritance Example
class Animal {
    protected $name;
    
    public function __construct($name) {
        $this->name = $name;
    }
    
    public function makeSound() {
        return "Some sound";
    }
}

class Dog extends Animal {
    public function makeSound() {
        return "Woof!";
    }
}

// Polymorphism Example
interface PaymentMethod {
    public function processPayment($amount);
}

class CreditCard implements PaymentMethod {
    public function processPayment($amount) {
        return "Processing $amount via Credit Card";
    }
}

class PayPal implements PaymentMethod {
    public function processPayment($amount) {
        return "Processing $amount via PayPal";
    }
}

// Usage Examples
$account = new BankAccount();
$account->deposit(100);
echo $account->getBalance(); // Outputs: 100

$rectangle = new Rectangle(5, 3);
echo $rectangle->calculateArea(); // Outputs: 15

$dog = new Dog("Buddy");
echo $dog->makeSound(); // Outputs: Woof!

$creditCard = new CreditCard();
$paypal = new PayPal();
echo $creditCard->processPayment(100); // Outputs: Processing 100 via Credit Card
echo $paypal->processPayment(100); // Outputs: Processing 100 via PayPal
?>