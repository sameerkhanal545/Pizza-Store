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
        <th scope="col-4" colspan="4">Actions </th>
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
          <td colspan="4" >
            <a class="btn btn-secondary" href="editPizza.php?PizzaID=<?php echo $rowPizza->getPizzaID(); ?>">Edit</a>
            <a class="btn btn-danger" href="addPrices.php?PizzaID=<?php echo $rowPizza->getPizzaID(); ?>">Add Price</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>