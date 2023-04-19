<?php
if (!defined('SITE_ROOT'))
    define('SITE_ROOT', __DIR__ . "/../");

require_once(SITE_ROOT . "/db/dbhelper.php");

require_once("cart.php");

class CartItem
{
    private $CartItemID;
    private $PizzaID;
    private $CustomerID;
    private $Quantity;
    private $Price;
    private $Size;
    private $PizzaName;
    private $PizzaImage;


    protected $errors = [];

    function getErrors()
    {
        return $this->errors;
    }
    function clearErrors()
    {
        $this->errors = [];
    }

    public function __construct($data = [])
    {
        if (isset($data["PizzaID"]))
            $this->PizzaID = $this->validateID($data['PizzaID']);
        if (isset($data["Quantity"]))
            $this->Quantity = $this->validateQuantity($data['Quantity']);
        if (isset($data["Price"]))
            $this->Price = $this->validatePrice($data['Price']);
        if (isset($data["CartItemID"]))
            $this->CartItemID = $this->validatePrice($data['CartItemID']);
        if (isset($data["CustomerID"]))
            $this->CustomerID = $this->validatePrice($data['CustomerID']);
        if (isset($data["Name"]))
            $this->PizzaName = $data['Name'];
        if (isset($data["PizzaImage"]))
            $this->PizzaImage = $data['PizzaImage'];
            if (isset($data["Size"]))
            $this->Size = $data['Size'];
    }

    public function getCartItemID()
    {
        return $this->CartItemID;
    }

    public function setCartItemID($CartItemID)
    {
        $this->CartItemID = $this->validateID($CartItemID);
    }

    public function getPizzaID()
    {
        return $this->PizzaID;
    }

    public function setPizzaID($PizzaID)
    {
        $this->PizzaID = $this->validateID($PizzaID);
    }

    public function getCustomerID()
    {
        return $this->CustomerID;
    }

    public function setCustomerID($CustomerID)
    {
        $this->CustomerID = $this->validateID($CustomerID);
    }

    public function getQuantity()
    {
        return $this->Quantity;
    }

    public function setQuantity($Quantity)
    {
        $this->Quantity = $this->validateQuantity($Quantity);
    }

    public function getPrice()
    {
        return $this->Price;
    }

    public function setPrice($Price)
    {
        $this->Price = $this->validatePrice($Price);
    }

    public function getSize()
    {
        return $this->Size;
    }

    public function setSize($Size)
    {
        $this->Size = $Size;
    }

    public function getPizzaName()
    {
        return $this->PizzaName;
    }

    public function setPizzaName($PizzaName)
    {
        $this->PizzaName = $PizzaName;
    }

    public function getPizzaImage()
    {
        return $this->PizzaImage;
    }

    public function setPizzaImage($PizzaImage)
    {
        $this->PizzaImage = $PizzaImage;
    }


    private function validateID($id)
    {
        $validatedID = filter_var($id, FILTER_VALIDATE_INT);
        if (!$validatedID || $validatedID <= 0) {
            $this->errors[] = 'Invalid ID.';
        }
        return $validatedID;
    }

    private function validateQuantity($quantity)
    {
        $validatedQuantity = filter_var($quantity, FILTER_VALIDATE_INT);
        if (!$validatedQuantity || $validatedQuantity <= 0) {
            $this->errors[] = 'Invalid quantity.';
        }
        return $validatedQuantity;
    }

    private function validatePrice($price)
    {
        $validatedPrice = filter_var($price, FILTER_VALIDATE_FLOAT);
        if (!$validatedPrice || $validatedPrice <= 0) {
            $this->errors[] = 'Invalid price.';
        }
        return $validatedPrice;
    }

    public function toArray()
    {
        return [
            'CartItemID' => $this->CartItemID,
            'PizzaID' => $this->PizzaID,
            'CustomerID' => $this->CustomerID,
            'Quantity' => $this->Quantity,
            'Price' => $this->Price,
            'Size' => $this->Size
        ];
    }

    public function insert()
    {
        $cart = new Cart();
        $pdo = DBHelper::getConnection();
        session_start();
        if (isset($_SESSION['CustomerID'])) {
            // get the CustomerID value from the session
            $this->CustomerID = $_SESSION['CustomerID'];
            $customerCart = $cart->findByCustomer($this->CustomerID);

            if (!$customerCart)
                $cart->insert($this->CustomerID);
            else
                $cart = $customerCart;

            // Prepare SQL statement
            $stmt = $pdo->prepare("INSERT INTO cart_item (PizzaID, CartID, Quantity,Size, Price)
                               VALUES (:PizzaID, :CartID, :Quantity,:Size, :Price)");

            // Bind parameters
            $stmt->execute([
                "PizzaID" => $this->PizzaID,
                "CartID" => $cart->getCartID(),
                "Quantity" => $this->Quantity,
                "Size" => $this->Size,
                "Price" => $this->Price
            ]);


            // Set the CartItemID property to the ID of the newly inserted row
            $this->CartItemID = $pdo->lastInsertId();
        }
    }

    public function findAllByCart($CartID)
    {
        $pdo = DBHelper::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM cart_item c join pizzas p on p.PizzaID = c.PizzaID WHERE c.CartID = :CartID");
        $stmt->execute(["CartID" => $CartID]);
        $cartItems = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cartItems[] = new CartItem($row);
        }
        return $cartItems;
    }

    public function removeFromCart($CartItemID)
    {
        $pdo = DBHelper::getConnection();
        $stmt = $pdo->prepare("DELETE FROM cart_item WHERE CartItemID = :CartItemID");
        return $stmt->execute(["CartItemID" => $CartItemID]);

    }

    public function deleteCartItemsByCart($cartID)
    {
        $pdo = DBHelper::getConnection();

        $sql = "DELETE FROM `cart_item` WHERE `CartID` = :cartID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':cartID', $cartID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount(); // Return the number of affected rows
    }

    public function getCartCount($customerID)
    {
        $pdo = DBHelper::getConnection();

        $sql = "SELECT count(*) FROM `cart_item` WHERE `CartID` in (SELECT CartID FROM cart where CustomerID = :customerID)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['customerID' => $customerID]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $cartCount = $row['count(*)'];
       return  $cartCount;
    }
}

?>