<?php
 require_once("../db/dbhelper.php");
  $pdo=DBHelper::getConnection();
 $query = 'SELECT * FROM provinces;';
    $stmt = $pdo->query($query);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    session_start();
    if (!empty($_SESSION['errors'])) {
      $errors = $_SESSION['errors'];
      $customerData = $_SESSION['customerData'];
      unset($_SESSION['errors']);
      unset($_SESSION['customerData']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/main.css" rel="stylesheet" />

</head>
<body>
    <?php require('../shared/header.php'); ?>
    <div>
        <form action = "register.php" method = "POST">
        <fieldset>
        <legend>Please enter your Info</legend>
        <input type="text" name="CustomerName" placeholder="Name *" 
        value="<?php echo $customerData['CustomerName'] ?? ''; ?>">  
        <?php if (!empty($errors['CustomerNameError'])) { ?>
        <span class="error"><?php echo $errors['CustomerNameError']; ?></span>
        <?php } 
        ?>
          <input type="text" name="CustomerPhone" placeholder="Phone number *" 
        value="<?php echo $customerData['CustomerPhone'] ?? ''; ?>">  
        <?php if (!empty($errors['CustomerPhoneError'])) { ?>
        <span class="error"><?php echo $errors['CustomerPhoneError']; ?></span>
        <?php } 
        ?>
        <input name="CustomerEmail" placeholder="Email *" value= <?php echo $customerData['CustomerEmail'] ?? ''; ?>
        <?php if (!empty($errors['CustomerEmailError'])) { ?>
        <span class="error"><?php echo $errors['CustomerEmailError']; ?></span>
        <?php } 
        ?>
        <label for="password">Password:</label>
        <input type = "password" id ="password" name="PasswordHash" value=<?php echo $customerData['CustomerEmail'] ?? ''; ?>
        <?php if (!empty($errors['PasswordError'])) { ?>
        <span class="error"><?php echo $errors['PasswordError']; ?></span>
        <?php } 
        ?>
      
        <label for="ProvinceID">Province:</label>
        <select id="ProvinceID" name="ProvinceID">
        <optgroup label="Types">
            <option value = ""  selected="selected" disabled>Select Province</option>
          <?php
         
                foreach ($results as $row) {
                    if(!empty($scooterData) && !empty($customerData["Province"]) && $customerData["Province"] ===  $row["ProvinceID"])
                        echo "<option value =". $row["ProvinceID"]." selected>".$row["Name"]."</option>";
                    else
                        echo "<option value =". $row["ProvinceID"].">".$row["Name"]."</option>";
                }
            
          ?>
        </optgroup>
        </select>
        
        <input type="text" name="CustomerCity" placeholder="City *"  value="<?php echo $customerData['CustomerCity'] ?? ''; ?>">
         <?php if (!empty($errors['CustomerCityError'])) { ?>
        <span class="error"><?php echo $errors['CustomerCityError']; ?></span>
        <?php } 
        ?>
        <input type="text" name="CustomerAddress" placeholder="Street *"  value="<?php echo $customerData['CustomerAddress'] ?? ''; ?>">
         <?php if (!empty($errors['CustomerAddressError'])) { ?>
        <span class="error"><?php echo $errors['CustomerAddressError']; ?></span>
        <?php } 
        ?>
     
        <input type="submit" value="ADD" />
        </fieldset>
        </form>
        </div>
</body>
    <?php require('../shared/footer.php'); ?>
</html>















