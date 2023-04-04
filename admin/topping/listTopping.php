
<?php
require_once "topping.php"; // include the dbhelper.php file

$topping = new Topping([]);

$toppings = $topping -> findAll(); // get the list of toppings
?>
<!DOCTYPE html>
<html>
<head>
  <title>List of Toppings</title>
</head>
<body>
  <h1>List of Toppings</h1>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($toppings as $topping): ?>
        <tr>
          <td><?php echo $topping['ToppingID'] ?></td>
          <td><?php echo $topping['ToppingName'] ?></td>
          <td><?php echo $topping['ToppingDescription'] ?></td>
          <td><?php echo "<a class='button primary' href='editTopping.php?topping_id={$topping['ToppingID']}'>Edit</a>" ?></td>
          <td><?php echo "<a class='button danger' href='deleteTopping.php?topping_id={$topping['ToppingID']}'>Delete</a>" ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>















