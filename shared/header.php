<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
  integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
  crossorigin="anonymous" referrerpolicy="no-referrer" />
  
<link href="../css/site.css" rel="stylesheet" />
<?php require_once("config.php") ?>
<?php

$loggedIn = false;
$isAdmin = false;

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
if (isset($_SESSION['CustomerID'])) {
  $loggedIn = true;
  if ($_SESSION['Role'] == "Admin")
    $isAdmin = true;
  if (!$isAdmin) {
    require_once("../cart/cartItem.php");
    $cartItem = new CartItem();
    $cartCount = 0;
    $cartCount = $cartItem->getCartCount($_SESSION['CustomerID']);
  }
}

?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-0 ">
  <div class="container-xl">
    <!-- Logo -->
    <a class="navbar-brand" href="#">
      <img src="<?php BASE_PATH?>/images/logo.png" class="h-8" alt="..." width="100" height="80">
    </a>
    <!-- Navbar toggle -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
      aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- Collapse -->
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <!-- Nav -->
      <div class="navbar-nav mx-lg-auto">
        <a class="nav-item nav-link active" href="/products/products.php" aria-current="page">Home</a>
        <a class="nav-item nav-link" href="#">

        </a>
        <?php if ($loggedIn & !$isAdmin) { ?>
          <a class="nav-item nav-link active" href="/order/orderList.php">Orders</a>
        <?php } else if ($loggedIn & $isAdmin) { ?>

          <a class="nav-item nav-link active" href="/admin/pizza/addPizza.php">Add Pizza</a>
          <a class="nav-item nav-link active" href="/admin/pizza/listPizza.php">List Pizza</a>

          <?php }?>
      </div>
      <!-- Right navigation -->
      <?php if (!$loggedIn) { ?>
        <div class="navbar-nav ms-lg-4">
          <a class="nav-item nav-link" href="/">Sign in</a>
        </div>
        <!-- Action -->
        <div class="d-flex align-items-lg-center mt-3 mt-lg-0">
          <a href="/customers/addCustomer.php" class="btn btn-sm btn-primary w-full w-lg-auto">
            Register
          </a>
        </div>
      <?php } else if (!$isAdmin) { ?>
          <a class="nav-link" href="../cart/cartList.php">
            <i class="fa-solid fa-cart-shopping fa-xl" style="color: #ffffff;"></i>
            <span class="badge badge-warning rounded-circle" style="padding: 4px;"><sup>
              <?php echo $cartCount ?>
              </sup></span>
          </a>
      <?php }
      if ($loggedIn) { ?>
        <a class="nav-link" style="color: #ffffff;" href="../login/logout.php">
          Logout
        </a>
      <?php } ?>
    </div>
  </div>
</nav>