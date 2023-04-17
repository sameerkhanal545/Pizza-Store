<!-- editPizza.php -->

<?php
require_once("../../db/dbhelper.php");
require_once("pizza.php");
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  // retrieve pizza data from database
  $id = $_GET["PizzaID"];
  if ($id) {
    $pizza = new Pizza();
    $pizzaToEdit = $pizza->findOne($id);
    var_dump($pizzaToEdit);
    if (!$pizzaToEdit) {
      header("Location: listPizza.php");
      exit();
    }
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // collect form data
  $id = $_POST["id"];
  $name = $_POST["name"];
  $description = $_POST["description"];
  $toppings = $_POST["toppings"];
  $size = $_POST["size"];
  $price = $_POST["price"];

  // update pizza in database
  $query = "UPDATE pizza SET name = '$name', description = '$description', toppings = '$toppings', size = '$size', price = '$price' WHERE id = $id";
  $result = mysqli_query($conn, $query);

  if ($result) {
    // redirect to listPizza.php on successful update
    header("Location: listPizza.php");
    exit();
  } else {
    echo "Error updating pizza: " . mysqli_error($conn);
  }
}
?>
<?php
require_once "../../shared/header.php";

?>
<div class="container">
  <h2>Edit Pizza</h2>

  <form action="edit.php" method="POST" enctype="multipart/form-data">
    <input type="text" name="PizzaID" value="<?php echo $pizzaToEdit->getPizzaID() ?? '' ?>">

    <div class="form-group row mt-2">
      <label for="name">Name:</label>
      <input class="form-control" type="text" name="PizzaName" id="name"
        value="<?php echo $pizzaToEdit->getPizzaName() ?? '' ?>" required>
    </div>
    <div class="form-group row mt-4">
      <label for="description">Description:</label>
      <textarea class="form-control" name="PizzaDescription" value=""
        id="description" required><?php echo $pizzaToEdit->getPizzaDescription() ?? '' ?></textarea>
    </div>
    <div class="form-group row mt-4">
      <label for="toppings">Toppings:</label>
      <input class="form-control" class="form-control" type="text" name="toppings" id="toppings" required>
    </div>
    <div class="form-group row mt-4">
      <label for="image">Image:</label>
      <input class="form-control" type="file" name="PizzaImage" id="image" required>
    </div>
    <div class="form-group row mt-4">
      <button class="btn btn-primary" type="submit">Edit Pizza</button>
    </div>
  </form>
</div>