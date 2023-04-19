<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['CustomerID'])) {
    header("Location: /");
    exit();
}
require_once "../admin/pizza/pizza.php";

$pizza = new Pizza([]);

$pizzas = $pizza->findAll(); // get the list of pizzas
?>


<body>
    <?php require('../shared/header.php'); ?>

    <div class="container body-content">

        <div class="jumbotron text-white jumbotron-image shadow"
            style="background-image: url('../images/pizza-bg.jpg');">
            <div class="overlay">
                <div class="banner-body">
                    <h1>Pizza Store</h1>
                    <p class="lead">Your One stop shot for delecious Pizzas</p>
                    <p><a href="#" class="btn btn-primary btn-lg">Order Now »</a></p>
                </div>
            </div>
        </div>
        <div class="row">
            <h2>Top Pick of the Day</h2>
            <?php foreach ($pizzas as $rowPizza): ?>
                <div class="col-sm-3">

                    <div class="card align-items-center text-white" style="width: 18rem;">
                        <img src="../admin/pizza/images/<?php echo $rowPizza->getPizzaImage(); ?>" class=" card-img"
                            alt="<?php echo $rowPizza->getPizzaName(); ?>">
                        <div class="card-body bg-dark">
                            <h5 class="card-title">
                                <?php echo $rowPizza->getPizzaName(); ?>
                            </h5>
                            <p class="card-text">
                                <?php echo $rowPizza->getPizzaDescription(); ?>
                            </p>
                            <a name="viewDetails" href="pizzaDetails.php?PizzaId=<?php echo $rowPizza->getPizzaID() ?>"
                                id="viewDetails" class="btn btn-primary">View Details</a>
                        </div>
                    </div>



                </div>
            <?php endforeach; ?>
        </div>




        <hr>


    </div>
    <?php require('../shared/footer.php'); ?>
</body>