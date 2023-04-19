<!-- addPRices.php -->

<?php
require_once("../../db/dbhelper.php");
require_once("pizza.php");
require_once("pizzaPrices.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // retrieve pizza data from database
    $id = $_GET["PizzaID"];
    if ($id) {
      $pizzaPrices = new PizzaPrices();
      $priceToEdit = $pizzaPrices->findByPizzaId($id);
      if (!$priceToEdit) {
        header("Location: listPizza.php");
        exit();
      }    

      $pizza = new Pizza();
      $pizzaToEdit = $pizza->findOne($id);

      $sizes = array("Small", "Medium", "Large");
        foreach ($priceToEdit as $price) {
            if (in_array($price->getSize(), $sizes)) {
            $sizes = \array_diff($sizes,[$price->getSize()]);
            }
        }        
    }
  }

?>

<?php
require_once "../../shared/header.php";

?>
<div class="container">
  <h2>Add Price</h2>

  <form action="price.php" method="POST" enctype="multipart/form-data">
        <div class="form-group row mt-4">
            <label for="PizzaName">Pizza:</label>
            <input type="text" disabled  name="PizzaName" id="PizzaName" value="<?php echo $pizzaToEdit->getPizzaName() ?? '' ?>">
            <input type="number"  hidden name="PizzaID" value="<?php echo $pizzaToEdit->getPizzaID() ?? '' ?>">
        </div>
        <div class="form-group row mt-4">
            <label for="size">Size:</label>
            <select class="form-control"  name="Size" id="Size" required>
                <?php foreach ($sizes as $size) { ?>
                    <option value="<?php echo $size; ?>"><?php echo $size; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group row mt-4">
            <label for="price">Price:</label>
            <input class="form-control"  type="number" name="Price" id="Price" required>
        </div>
        <div class="form-group row mt-4">
            <button class="btn btn-primary" type="submit">Save Price</button>
        </div> 
  </form>
</div>