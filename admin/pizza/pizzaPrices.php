<?php
// define('SITE_ROOT', __DIR__ . "/../../");

require_once(SITE_ROOT . "/db/dbhelper.php");
class PizzaPrices
{
    private $PriceID;
    private $Size;
    private $Price;

    public function getPriceID()
    {
        return $this->PriceID;
    }

    public function setPriceID($PriceID)
    {
        // Check for valid ID format
        if (!is_numeric($PriceID) || $PriceID <= 0) {
            throw new InvalidArgumentException('Invalid PriceID format');
        }
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
    function __construct($properties = [])
    {
        if (isset($properties["PriceID"]))
            $this->setPriceID($properties["PriceID"]);
        if (isset($properties["Size"]))
            $this->setSize($properties["Size"]);
        if (isset($properties["Price"]))
            $this->setPrice($properties["Price"]);

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
                $price->PriceID = $row["PizzaID"];
                $price->Price = $row["Price"];
                $price->Size = $row["size"];
                $prices[] = $price;
            }

            return $prices;
        }
    }

}
?>