<?php
if (!defined('SITE_ROOT'))
    define('SITE_ROOT', __DIR__ . "/../");

require_once(SITE_ROOT . "/db/dbhelper.php");


class OrderItem
{
    private $OrderItemID;
    private $PizzaID;
    private $OrderID;
    private $Quantity;
    private $Price;
    private $Size;
    private $PizzaName;
    private $PizzaImage;

    protected $errors = [];

    public function __construct($data = [])
    {
        if (isset($data["PizzaID"]))
            $this->setPizzaID($data['PizzaID']);
        if (isset($data["OrderID"]))
            $this->setOrderID($data['OrderID']);
        if (isset($data["Quantity"]))
            $this->setQuantity($data['Quantity']);
        if (isset($data["Size"]))
            $this->setSize($data['Size']);
        if (isset($data["Price"]))
            $this->setPrice($data['Price']);
        if (isset($data["Name"]))
            $this->PizzaName = $data['Name'];
        if (isset($data["PizzaImage"]))
            $this->PizzaImage = $data['PizzaImage'];
    }

    public function getOrderItemID()
    {
        return $this->OrderItemID;
    }

    public function setOrderItemID($OrderItemID)
    {
        if (!is_numeric($OrderItemID) || $OrderItemID <= 0) {
            $this->errors['OrderItemID'] = 'Invalid Order Item ID';
        } else {
            $this->OrderItemID = $OrderItemID;
        }
    }

    public function getPizzaID()
    {
        return $this->PizzaID;
    }

    public function setPizzaID($PizzaID)
    {
        if (!is_numeric($PizzaID) || $PizzaID <= 0) {
            $this->errors['PizzaID'] = 'Invalid Pizza ID';
        } else {
            $this->PizzaID = $PizzaID;
        }
    }

    public function getOrderID()
    {
        return $this->OrderID;
    }

    public function setOrderID($OrderID)
    {
        if (!is_numeric($OrderID) || $OrderID <= 0) {
            $this->errors['OrderID'] = 'Invalid Order ID';
        } else {
            $this->OrderID = $OrderID;
        }
    }

    public function getQuantity()
    {
        return $this->Quantity;
    }

    public function setQuantity($Quantity)
    {
        if (!is_numeric($Quantity) || $Quantity <= 0) {
            $this->errors['Quantity'] = 'Invalid Quantity';
        } else {
            $this->Quantity = $Quantity;
        }
    }

    public function getPrice()
    {
        return $this->Price;
    }

    public function setPrice($Price)
    {
        if (!is_numeric($Price) || $Price <= 0) {
            $this->errors['Price'] = 'Invalid Price';
        } else {
            $this->Price = $Price;
        }
    }

    public function getSize()
    {
        return $this->Size;
    }

    public function setSize($Size)
    {
        if (empty($Size)) {
            $this->errors['Size'] = 'Size is required';
        } else {
            $this->Size = $Size;
        }
    }

    public function getPizzaName()
    {
        return $this->PizzaName;
    }

    public function setPizzaName($PizzaName)
    {
        if (empty($PizzaName)) {
            $this->errors['PizzaName'] = 'Pizza name is required';
        } else {
            $this->PizzaName = $PizzaName;
        }
    }

    public function getPizzaImage()
    {
        return $this->PizzaImage;
    }

    public function setPizzaImage($PizzaImage)
    {
        if (empty($PizzaImage)) {
            $this->errors['PizzaImage'] = 'Pizza image is required';
        } else {
            $this->PizzaImage = $PizzaImage;
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function insert($orderItems)
    {
        $pdo = DBHelper::getConnection();

        $sql = "INSERT INTO order_item (OrderID, PizzaID, Quantity, Price, Size) VALUES (:OrderID, :PizzaID, :Quantity, :Price, :Size)";

        $stmt = $pdo->prepare($sql);

        foreach ($orderItems as $orderItem) {
            $stmt->bindParam(":OrderID", $orderItem->getOrderID());
            $stmt->bindParam(":PizzaID", $orderItem->getPizzaID());
            $stmt->bindParam(":Quantity", $orderItem->getQuantity());
            $stmt->bindParam(":Price", $orderItem->getPrice());
            $stmt->bindParam(":Size", $orderItem->getSize());
            $stmt->execute();
        }

        $conn = null;
    }


}

?>