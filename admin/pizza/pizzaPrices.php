<?php
if (!defined('SITE_ROOT'))
define('SITE_ROOT', __DIR__ . "/../../");

require_once(SITE_ROOT . "/db/dbhelper.php");
class PizzaPrices
{
    private $PriceID;
    private $Size;
    private $Price;
    private $PizzaID;

    public function getPriceID()
    {
        return $this->PriceID;
    }

    public function setPriceID($PriceID)
    {
        $this->PriceID = trim(htmlspecialchars($PriceID));
    }

    public function getSize()
    {
        return $this->Size;
    }

    public function setSize($Size)
    {
        // Check for valid size
        $this->Size = trim(htmlspecialchars($Size));
        if (!isset($this->Size)) {
            throw new InvalidArgumentException('Size is required.');
        }

    }

    public function getPrice()
    {
        return $this->Price;
    }

    public function setPrice($Price)
    {
        $this->Price = trim(htmlspecialchars($Price));

        // Check for valid price format
        if (!is_numeric($this->Price) || $this->Price < 0) {
            throw new InvalidArgumentException('Invalid price');
        }
    }
    public function getPizzaID()
    {
        return $this->PizzaID;
    }

    public function setPizzaID($PizzaID)
    {
        // Check for valid ID format
        if (!is_numeric($PizzaID) || $PizzaID <= 0) {
            throw new InvalidArgumentException('Invalid PizzaID format');
        }
        $this->PizzaID = trim(htmlspecialchars($PizzaID));
    }
    function __construct($properties = [])
    {
        if (isset($properties["PriceID"]))
            $this->setPriceID($properties["PriceID"]);
        if (isset($properties["Size"]))
            $this->setSize($properties["Size"]);
        if (isset($properties["Price"]))
            $this->setPrice($properties["Price"]);
        if (isset($properties["PizzaID"]))
            $this->setPizzaID($properties["PizzaID"]);
    }

    public function findByPizzaId($PizzaID)
    {
        if (filter_var($PizzaID, FILTER_VALIDATE_INT)) {
            $pdo = DBHelper::getConnection();
            $stmt = $pdo->prepare("select * from prices where 
                          PizzaID=:PizzaID  
            ");
            $stmt->execute(["PizzaID" => (int) $PizzaID]);

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $prices = array();
            foreach ($rows as $row) {
                $price = new PizzaPrices([]);
                $price->PriceID = $row["PriceID"];
                $price->Price = $row["Price"];
                $price->Size = $row["size"];
                $price->PizzaID = $row["PizzaID"];
                $prices[] = $price;
            }

            return $prices;
        }
    }

    public function getErrors($isUpdate)
    {
        $errors = [];

        if (empty($this->Price)) {
            $errors[] = "Pizza price is required.";
        }

        if (empty($this->Size)) {
            $errors[] = "Pizza size is required.";
        }

        return $errors;
    }

    public function create()
    {
        $query = "INSERT INTO prices (PizzaID, size, Price) 
        VALUES (:PizzaID, :size, :Price)";
            $params = array(
                ":PizzaID" => $this->PizzaID,
                ":size" => $this->Size,
                ":Price" => $this->Price
            );
        
        $pdo = DBHelper::getConnection();
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $PizzaId = $pdo->lastInsertId();
    }

}
?>