<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if (isset($_SESSION['Error'])) {
    $error = $_SESSION['Error'];
    unset($_SESSION['Error']);
}
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RoadHouse Pizza</title>
</head>

<body>
    <?php require_once("shared/header.php") ?>

    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3 ">
                <h2 class="text-center text-dark mt-5">Login In</h2>
                <div class="card my-5">

                    <form class="card-body cardbody-color p-lg-5 justify-content-center" method="POST" action="login/login.php">
                        <span class="text-danger">
                            <?php echo $error ?? ''?>
                        </span>
                        <div class="text-center">
                            <img src="images/logo.png"
                                class="img-fluid profile-image-pic img-thumbnail rounded-circle my-3" width="200px"
                                alt="profile">
                        </div>

                        <div class="mb-3 justify-content-center">
                            <div class="input-group">
                            <input type="text" class="form-control mx-auto" id="Email" name="Email" aria-describedby="emailHelp"
                                placeholder="Email">
                                </div>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control mx-auto" id="password" name="Password"
                                placeholder="password">
                        </div>
                        <div class="text-center"><button type="submit"
                                class="btn btn-primary px-5 mb-5 w-90">Login</button></div>
                        <div id="emailHelp" class="form-text text-center mb-5 text-dark">Not
                            Registered? <a href="customers/addCustomer.php" class="text-dark fw-bold"> Create an
                                Account</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</body>

</html>