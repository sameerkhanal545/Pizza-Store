<?php
if (!defined('SITE_ROOT'))
    define('SITE_ROOT', __DIR__ . "/../");
require_once(SITE_ROOT . "/db/dbhelper.php");
require_once("orderItem.php");

require_once("../cart/cartItem.php");
class Order
{
    private $OrderID;
    private $CustomerID;
    private $ShippingAddress;
    private $ZipCode;
    private $ShppingCustomerName;
    private $TotalPrice;
    private $OrderDate;
    private $Status;

    protected $errors = [];

    public function __construct($data = [])
    {
        if (isset($data["OrderID"]))
            $this->setOrderID($data["OrderID"]);
        if (isset($data["CustomerID"]))
            $this->setCustomerID($data["CustomerID"]);
        if (isset($data["ShippingAddress"]))
            $this->setShippingAddress($data["ShippingAddress"]);
        if (isset($data["ZipCode"]))
            $this->setZipCode($data["ZipCode"]);
        if (isset($data["ShppingCustomerName"]))
            $this->setShppingCustomerName($data["ShppingCustomerName"]);
        if (isset($data["TotalPrice"]))
            $this->setTotalPrice($data["TotalPrice"]);
        if (isset($data["OrderDate"]))
            $this->setOrderDate($data["OrderDate"]);
        if (isset($data["Status"]))
            $this->setStatus($data["Status"]);
    }

    public function getOrderID()
    {
        return $this->OrderID;
    }

    public function setOrderID($OrderID)
    {
        $this->OrderID = $OrderID;
    }

    public function getCustomerID()
    {
        return $this->CustomerID;
    }

    public function setCustomerID($CustomerID)
    {
        if (!is_numeric($CustomerID)) {
            $this->errors['CustomerID'] = 'CustomerID must be a number';
        }
        $this->CustomerID = $CustomerID;
    }

    public function getShippingAddress()
    {
        return $this->ShippingAddress;
    }

    public function setShippingAddress($ShippingAddress)
    {
        if (strlen($ShippingAddress) > 255) {
            $this->errors['ShippingAddress'] = 'ShppingAddress cannot be longer than 255 characters';
        }
        $this->ShippingAddress = $ShippingAddress;
    }

    public function getZipCode()
    {
        return $this->ZipCode;
    }

    public function setZipCode($ZipCode)
    {
        if (strlen($ZipCode) > 255) {
            $this->errors['ZipCode'] = 'ZipCode cannot be longer than 255 characters';
        }
        $this->ZipCode = $ZipCode;
    }

    public function getShppingCustomerName()
    {
        return $this->ShppingCustomerName;
    }

    public function setShppingCustomerName($ShppingCustomerName)
    {
        if (strlen($ShppingCustomerName) > 255) {
            $this->errors['ShppingCustomerName'] = 'ShppingCustomerName cannot be longer than 255 characters';
        }
        $this->ShppingCustomerName = $ShppingCustomerName;
    }

    public function getTotalPrice()
    {
        return $this->TotalPrice;
    }

    public function setTotalPrice($TotalPrice)
    {
        if (!is_numeric($TotalPrice)) {
            $this->errors['TotalPrice'] = 'TotalPrice must be a number';
        }
        $this->TotalPrice = $TotalPrice;
    }

    public function getOrderDate()
    {
        return $this->OrderDate;
    }

    public function setOrderDate($OrderDate)
    {
        $this->OrderDate = $OrderDate;
    }

    public function getStatus()
    {
        return $this->Status;
    }

    public function setStatus($Status)
    {
        if (!in_array($Status, ['PENDING', 'PAID', 'CANCELLED'])) {
            $this->errors['Status'] = 'Invalid status';
        }
        $this->Status = $Status;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function insert($cartItems, $CartID)
    {
        $pdo = DBHelper::getConnection();
        $totalPrice = 0;
        foreach ($cartItems as $cartItem) {
            $totalPrice += $cartItem->getPrice() * $cartItem->getQuantity();
        }
        try {
            $stmt = $pdo->prepare("INSERT INTO orders (CustomerID, ShppingAddress, ZipCode, ShppingCustomerName, TotalPrice,Status) VALUES (:customerID, :shippingAddress, :zipCode, :shippingCustomerName, :totalPrice,:status)");
            $stmt->bindParam(':customerID', $this->CustomerID);
            $stmt->bindParam(':shippingAddress', $this->ShippingAddress);
            $stmt->bindParam(':zipCode', $this->ZipCode);
            $stmt->bindParam(':shippingCustomerName', $this->ShppingCustomerName);
            $stmt->bindParam(':totalPrice', $totalPrice);
            $stmt->bindParam(':status', $this->Status);

            $stmt->execute();

            // Get the ID of the inserted order
            $this->OrderID = $pdo->lastInsertId();

            $orderItems = [];
            foreach ($cartItems as $cartItem) {
                $orderItem = new OrderItem([
                    'OrderID' => $this->OrderID,
                    'PizzaID' => $cartItem->getPizzaID(),
                    'Quantity' => $cartItem->getQuantity(),
                    'Price' => $cartItem->getPrice(),
                    'Size' => $cartItem->getSize(),
                ]);
                $orderItems[] = $orderItem;
            }
            var_dump($cartItems);

            $orderItem = new OrderItem();
            $orderItem->insert($orderItems);
            $cartItem->deleteCartItemsByCart($CartID);
            return true;
        } catch (PDOException $e) {
            $this->errors[] = "Error inserting order into database: " . $e->getMessage();
            var_dump($this->errors);
            return false;
        }
    }
    public function findByCustomer($CustomerID)
    {
        $pdo = DBHelper::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE CustomerID = :CustomerID");
        $stmt->bindParam(":CustomerID", $CustomerID);
        $stmt->execute();
        // $orders = $stmt->fetch(PDO::FETCH_ASSOC);
        $orderList = [];
        while ($order = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $orderObj = new Order();
            $orderObj->setOrderID($order['OrderID']);
            $orderObj->setCustomerID($order['CustomerID']);
            $orderObj->setOrderDate($order['OrderDate']);
            $orderObj->setShippingAddress($order['ShppingAddress']);
            $orderObj->setShppingCustomerName($order['ShppingCustomerName']);
            $orderObj->setStatus($order['Status']);
            $orderObj->setTotalPrice($order['TotalPrice']);

            $orderList[] = $orderObj;

            
        }
        return $orderList;
    }

}
?>