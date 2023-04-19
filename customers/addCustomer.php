<?php require('../shared/header.php'); ?>

<?php
require_once(__DIR__ . "/../db/dbhelper.php");

$pdo = DBHelper::getConnection();
$query = 'SELECT * FROM provinces;';
$stmt = $pdo->query($query);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
if (!empty($_SESSION['errors'])) {
  $errors = $_SESSION['errors'];
  $customerData = $_SESSION['customerData'];
  unset($_SESSION['errors']);
  unset($_SESSION['customerData']);
}
?>
<!DOCTYPE html>
<html lang="en">


<body>
  <div class="container mx-auto">
    <div class="row mx-auto justify-content-center mb-3 w-60">
      <form action="register.php" method="POST">
        <fieldset>
          <legend class="text-center">Please enter your Info</legend>
          <div class="form-group row mt-4">
            <label for="name">Name:</label>
            <input type="text" class="form-control" name="CustomerName" id="name" placeholder="Name *"
              value="<?php echo $customerData['CustomerName'] ?? ''; ?>">
            <?php if (!empty($errors['CustomerNameError'])) { ?>
              <span class="text-danger">
                <?php echo $errors['CustomerNameError']; ?>
              </span>
            <?php }
            ?>
          </div>
          <div class="form-group row mt-4">
            <label for="phone">Phone Number:</label>
            <input type="text" class="form-control" id="phone" name="CustomerPhone" placeholder="Phone number *"
              value="<?php echo $customerData['CustomerPhone'] ?? ''; ?>">
            <?php if (!empty($errors['CustomerPhoneError'])) { ?>
              <span class="text-danger">
                <?php echo $errors['CustomerPhoneError']; ?>
              </span>
            <?php }
            ?>
          </div>
          <div class="form-group row mt-4">
            <label for="email">Email:</label>
            <input type="text" class="form-control" name="CustomerEmail" id="email" placeholder="Email *"
              value="<?php echo $customerData['CustomerEmail'] ?? ''; ?>">
            <?php if (!empty($errors['CustomerEmailError'])) { ?>
              <span class="text-danger">
                <?php echo $errors['CustomerEmailError']; ?>
              </span>
            <?php }
            ?>
          </div>
          <div class="form-group row mt-4">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="PasswordHash"
              value="<?php echo $customerData['CustomerEmail'] ?? ''; ?>">
            <?php if (!empty($errors['PasswordError'])) { ?>
              <span class="text-danger">
                <?php echo $errors['PasswordError']; ?>
              </span>
            <?php }
            ?>
          </div>
          <div class="form-group row mt-4 col-sm-6">
            <label for="ProvinceID">Province:</label>
            <select id="ProvinceID" class="form-select" name="ProvinceID">
              <optgroup label="Types">
                <option value="" selected="selected" disabled>Select Province</option>
                <?php

                foreach ($results as $row) {
                  if (!empty($scooterData) && !empty($customerData["Province"]) && $customerData["Province"] === $row["ProvinceID"])
                    echo "<option value =" . $row["ProvinceID"] . " selected>" . $row["Name"] . "</option>";
                  else
                    echo "<option value =" . $row["ProvinceID"] . ">" . $row["Name"] . "</option>";
                }

                ?>
              </optgroup>
            </select>
            <?php if (!empty($errors['ProvinceIDError'])) { ?>
              <span class="text-danger">
                <?php echo $errors['ProvinceIDError']; ?>
              </span>
            <?php }
            ?>
          </div>
          <div class="form-group row mt-4">
            <label for="city">City:</label>
            <input type="text" class="form-control" name="CustomerCity" id="city" placeholder="City *"
              value="<?php echo $customerData['CustomerCity'] ?? ''; ?>">
            <?php if (!empty($errors['CustomerCityError'])) { ?>
              <span class="text-danger">
                <?php echo $errors['CustomerCityError']; ?>
              </span>
            <?php }
            ?>
          </div>
          <div class="form-group row mt-4">
            <label for="address">Address:</label>
            <input type="text" class="form-control" name="CustomerAddress" id="address" placeholder="Street *"
              value="<?php echo $customerData['CustomerAddress'] ?? ''; ?>">
            <?php if (!empty($errors['CustomerAddressError'])) { ?>
              <span class="text-danger">
                <?php echo $errors['CustomerAddressError']; ?>
              </span>
            <?php }
            ?>
          </div>
          <div class="form-group row mt-4">
            <input type="submit" class="btn btn-primary" value="ADD" />
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</body>
<?php require('../shared/footer.php'); ?>

</html>