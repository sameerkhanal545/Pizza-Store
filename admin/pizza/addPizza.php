<!-- addPizza.php -->

<?php
require_once "../../shared/header.php";

?>
<div class="container">
<h2>Add a New Pizza</h2>

<form action="add.php" method="POST" enctype="multipart/form-data">
  <div class="form-group row mt-2">
    <label for="name">Name:</label>
    <input  class="form-control" type="text" name="PizzaName" id="name" required>
  </div>
  <div class="form-group row mt-4">
    <label for="description">Description:</label>
    <textarea class="form-control"  name="PizzaDescription" id="description" required></textarea>
  </div>
  <div class="form-group row mt-4">
    <label for="size">Size:</label>
    <select class="form-select"  name="PizzaSize" id="size" required>
      <option value="Small">Small</option>
      <option value="Medium">Medium</option>
      <option value="Large">Large</option>
    </select>
  </div>
  <div class="form-group row mt-4">
    <label for="price">Price:</label>
    <input class="form-control"  type="text" name="PizzaPrice" id="price" required>
  </div>
  <div class="form-group row mt-4">
    <label for="image">Image:</label>
    <input class="form-control"  type="file" name="PizzaImage" id="image" required>
  </div>
  <div class="form-group row mt-4">
  <button class="btn btn-primary" type="submit">Add Pizza</button>
  </div>
</form>
</div>