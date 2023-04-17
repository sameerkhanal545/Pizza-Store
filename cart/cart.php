<?php

require_once(SITE_ROOT . "/db/dbhelper.php");


class Cart
{
    private $CartID;
    private $CustomerID;

    public function getCartID()
    {
        return $this->CartID;
    }

    public function setCartID($CartID)
    {
        $this->CartID = $CartID;
    }

    public function getCustomerID()
    {
        return $this->CustomerID;
    }

    public function setCustomerID($CustomerID)
    {
        $this->CustomerID = $CustomerID;
    }

    public function findByCustomer($CustomerID)
    {
        $pdo = DBHelper::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM cart WHERE CustomerID = :CustomerID");
        $stmt->bindParam(":CustomerID", $CustomerID);
        $stmt->execute();
        $cart = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($cart) {
            $cartObj = new Cart();
            $cartObj->setCartID($cart['CartID']);
            $cartObj->setCustomerID($cart['CustomerID']);
            return $cartObj;
        }
        return null;
    }

    public function insert($customerId)
    {
        $pdo = DBHelper::getConnection();
        $stmt = $pdo->prepare("INSERT INTO cart (CustomerID) VALUES (:customerId)");
        $stmt->execute(['customerId' => $customerId]);
        $this->setCartID($pdo->lastInsertId());
        $this->CustomerID = $customerId;
    }
}

?>