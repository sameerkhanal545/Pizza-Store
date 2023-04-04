<?php
class DBHelper 
{
    
    const DB_USER ='root';
    const DB_PASSWORD = '';
    const DB_HOST = 'localhost:3306';
    const DB_NAME ='pizza_store';
    const CHARSET = 'utf8mb4';
    
    static protected $connection = null;
    
    static function getConnection($connectToDB=true)
    {
      if(self::$connection==null)
        {
            try
            {
                $data_source_name="mysql:host=".self::DB_HOST.";charset=".self::CHARSET;
                if($connectToDB)
                    $data_source_name .=";dbname=".self::DB_NAME;

                self::$connection=new PDO($data_source_name,self::DB_USER,self::DB_PASSWORD);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            }
            catch(PDOException $e)
            {
                echo "Connection failed: " . $e->getMessage();
            }
        }
        return self::$connection;
    }
    
    static function initializeDatabase()
    {
        try
        {
                $pdo = DBHelper::getConnection(false);
                $instance = new DBHelper();
                $pdo->query("drop database if exists pizza_store");
                $pdo->query("create database pizza_store");
                
                $pdo->query("use pizza_store");
                
                $instance->createProvinceTable($pdo);
                $instance->createCustomerTable($pdo);
                $instance->createPizzaPriceTable($pdo);
                $instance->createPaymentMethodTable($pdo);
                $instance->createPizzaTable($pdo);
                $instance->createPizzaToppingTable($pdo);
                $instance->createOrderTable($pdo);
                $instance->createCartTable($pdo);
                //load data
                $instance->loadProvinces($pdo);($pdo);

              
        }catch(PDOException $e)
        {
                echo "Database error: " . $e->getMessage();

        }
    }
    
       function createProvinceTable($pdo)
    {
        $pdo->query(
            "CREATE TABLE provinces (
                  ProvinceID INT PRIMARY KEY AUTO_INCREMENT,
                  Name VARCHAR(255) NOT NULL,
                  Abbreviation VARCHAR(10) NOT NULL
                )
            ");
    }
    

    public function createCustomerTable($pdo)
    {
        $pdo->query(
            "CREATE TABLE customers (
                CustomerID INT PRIMARY KEY AUTO_INCREMENT,
                CustomerName VARCHAR(255) NOT NULL,
                CustomerEmail VARCHAR(255) NOT NULL,
                CustomerPhone VARCHAR(20) NOT NULL,
                CustomerCity VARCHAR(20) NOT NULL,
                CustomerAddress VARCHAR(20) NOT NULL,
                PasswordHash VARCHAR(256) NOT NULL,
                ProvinceID INT NOT NULL,
                FOREIGN KEY (ProvinceID) REFERENCES provinces(ProvinceID)

                )
            ");
    }
    
    function createPaymentMethodTable($pdo)
    {
        $pdo->query(
            "CREATE TABLE payment_method (
                PaymentMethodID INT PRIMARY KEY AUTO_INCREMENT,
                CustomerID INT NOT NULL ,
                CardNumber VARCHAR(255) NOT NULL,
                CardHolderName VARCHAR(255) NOT NULL,
                ExpityDate VARCHAR(20) NOT NULL,
                CVV VARCHAR(20) NOT NULL,
                CONSTRAINT fk_payment_methods_customers
                FOREIGN KEY (CustomerID)
                REFERENCES customers(CustomerID)
                ON DELETE CASCADE
                )
            ");
    }

    function createOrderTable($pdo)
    {
        $pdo->query(
            "CREATE TABLE orders (
                OrderID INT(11) NOT NULL AUTO_INCREMENT,
                PizzaID INT(11) NOT NULL,
                CustomerID INT(11) NOT NULL,
                Quantity INT(11) NOT NULL,
                TotalPrice DECIMAL(10, 2) NOT NULL,
                OrderDate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                Status ENUM('PENDING', 'PAID', 'CANCELLED') NOT NULL DEFAULT 'PENDING',
                PRIMARY KEY (OrderID),
                FOREIGN KEY (PizzaID) REFERENCES pizzas(PizzaID),
                FOREIGN KEY (CustomerID) REFERENCES customers(CustomerID)
             )
            ");
    }

    function createPizzaTable($pdo)
    {
        $pdo->query(
            "CREATE TABLE pizzas (
                PizzaID INT(11) NOT NULL AUTO_INCREMENT,
                Name VARCHAR(255) NOT NULL,
                Description TEXT,
                PRIMARY KEY (PizzaID),
                PriceID INT NOT NULL,
                FOREIGN KEY (PriceID) REFERENCES prices(PriceID)
            )
            ");
    }

    function createPizzaPriceTable($pdo)
    {
        $pdo->query(
            "CREATE TABLE prices (
                PriceID INT(11) NOT NULL AUTO_INCREMENT,
                status ENUM('SMALL', 'MEDIUM', 'LARGE') NOT NULL DEFAULT 'MEDIUM',
                Price DECIMAL(10, 2) NOT NULL,
                PRIMARY KEY (PriceID)
            )
            ");
    }
    
       function createCartTable($pdo)
    {
        $pdo->query(
            "CREATE TABLE cart (
                  CartID INT NOT NULL AUTO_INCREMENT,
                  CustomerID INT NOT NULL,
                  PizzaID INT NOT NULL,
                  Size VARCHAR(10) NOT NULL,
                  Quantity INT NOT NULL,
                  PRIMARY KEY (CartID),
                  FOREIGN KEY (CustomerID) REFERENCES customers(CustomerID),
                  FOREIGN KEY (PizzaID) REFERENCES pizzas(PizzaID)
            )
            ");
    }

    function createPizzaToppingTable($pdo)
    {
        $pdo->query(
            "CREATE TABLE topping (
                ToppingID INT(11) NOT NULL AUTO_INCREMENT,
                ToppingName VARCHAR(255) NOT NULL,
                ToppingDescription VARCHAR(255) NOT NULL,
                PRIMARY KEY (ToppingID)
                )
            ");

        $pdo->query(
            "CREATE TABLE pizza_topping (
                PizzaID INT(11) NOT NULL AUTO_INCREMENT,
                ToppingID INT(11) NOT NULL,
                PRIMARY KEY (PizzaID, ToppingID),
                FOREIGN KEY (PizzaID) REFERENCES pizzas(PizzaID),
                FOREIGN KEY (ToppingID) REFERENCES topping(ToppingID)
                )
            ");
    }
    
    function loadData($pdo)
    {
       
    }
     function loadProvinces($pdo)
    {
        $stmt = $pdo->prepare("INSERT INTO provinces (Name, Abbreviation) VALUES (:Name, :Abbreviation)");
      
        // insert data
        $name = "Ontario";
        $code = "ON";
        $stmt->bindParam(':Name', $name);
        $stmt->bindParam(':Abbreviation', $code);
        
        $stmt->execute();
        
        $name = "Quebec";
        $code = "QC";
        $stmt->bindParam(':Name', $name);
        $stmt->bindParam(':Abbreviation', $code);
        
        $stmt->execute();
        
        $name = "British Columbia";
        $code = "BC";
        $stmt->bindParam(':Name', $name);
        $stmt->bindParam(':Abbreviation', $code);
        
        $stmt->execute();

    }
    
}
?>






























