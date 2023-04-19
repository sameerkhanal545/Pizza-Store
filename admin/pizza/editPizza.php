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
    if (!$pizzaToEdit) {
      header("Location: listPizza.php");
      exit();
    }
  }
}
?>
<?php
require_once "../../shared/header.php";

?>
<div class="container">
  <h2>Edit Pizza</h2>

  <form action="edit.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="PizzaID" value="<?php echo $pizzaToEdit->getPizzaID() ?? '' ?>">

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
      <label for="image">Image:</label>
      <input class="form-control" type="file" name="PizzaImage" id="image">
    </div>
    <div class="form-group row mt-4">
      <button class="btn btn-primary" type="submit">Edit Pizza</button>
    </div>
  </form>
</div>