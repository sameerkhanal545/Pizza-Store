<!DOCTYPE html>
<html lang="en">

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
            <div class="col-md-6 offset-md-3">
                <h2 class="text-center text-dark mt-5">Login In</h2>
                <div class="card my-5">

                    <form class="card-body cardbody-color p-lg-5" method="POST" action="login/login.php">

                        <div class="text-center">
                            <img src="https://cdn.pixabay.com/photo/2016/03/31/19/56/avatar-1295397__340.png"
                                class="img-fluid profile-image-pic img-thumbnail rounded-circle my-3" width="200px"
                                alt="profile">
                        </div>

                        <div class="mb-3">
                            <input type="text" class="form-control" id="Email" name="Email" aria-describedby="emailHelp"
                                placeholder="Email">
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" id="password" name="Password"
                                placeholder="password">
                        </div>
                        <div class="text-center"><button type="submit"
                                class="btn btn-primary px-5 mb-5 w-100">Login</button></div>
                        <div id="emailHelp" class="form-text text-center mb-5 text-dark">Not
                            Registered? <a href="#" class="text-dark fw-bold"> Create an
                                Account</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</body>

</html>