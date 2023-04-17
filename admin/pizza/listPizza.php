<!-- listPizza.php -->

<?php
require_once "../../shared/header.php";
require_once "pizza.php"; // include the dbhelper.php file

$pizza = new Pizza([]);

$pizzas = $pizza->findAll(); // get the list of pizzas
?>
<div class="container">
  <h2 class="text-center">List of Pizzas</h2>

  <table class="table  table-striped  table-bordered table-hover">
    <thead class="thead table-info">
      <tr>
        <th scope="col">Name</th>
        <th scope="col">Description</th>
        <th scope="col">Size</th>
        <th scope="col">Price</th>
        <th scope="col" colspan="2">Actions </th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($pizzas as $rowPizza): ?>
        <tr>
          <td scope="row">
            <?php echo $rowPizza->getPizzaName(); ?>
          </td>
          <td scope="row">
            <?php echo $rowPizza->getPizzaDescription(); ?>
          </td>
          <td scope="row">
            <?php echo $rowPizza->getPizzaSize(); ?>
          </td>
          <td scope="row">
            <?php echo $rowPizza->getPizzaPrice() ?>
          </td>
          <td colspan="2" >
            <a class="btn btn-secondary" href="editPizza.php?PizzaID=<?php echo $rowPizza->getPizzaID(); ?>">Edit</a>
            <a class="btn btn-danger" href="deletePizza.php?PizzaID=<?php echo $rowPizza->getPizzaID(); ?>">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>