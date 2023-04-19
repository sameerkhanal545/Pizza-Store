<!DOCTYPE html>
<html lang="en">
<?php
$PizzaId = $_GET["PizzaId"];
if (empty($PizzaId)) {
    echo '<p class="text-danger">No Pizza Detail Available</p>';
} else {
    require_once("../admin/pizza/pizza.php");
    require_once("../admin/pizza/pizzaPrices.php");
    $pizza = new Pizza([]);
    $pizza = $pizza->findOne($PizzaId);

    $price = new PizzaPrices([]);

    $prices = $price->findByPizzaId($PizzaId);
}
?>

<body>
    <?php require_once("../shared/header.php") ?>
    <div class="container my-5">

        <div class="card details-card p-0">
            <div class="row">

                <div class="col-md-6 col-sm-12">
                    <img class="img-fluid details-img"
                        src="../admin/pizza/images/<?php echo $pizza->getPizzaImage(); ?>"
                        alt=" <?php echo $pizza->getPizzaName(); ?>">
                </div>
                <div class="col-md-6 col-sm-12 description-container p-5">
                    <div class="main-description">

                        <h3 id="lblName">
                            <?php echo $pizza->getPizzaName(); ?>
                        </h3>
                        <hr>
                        <p id="lblprice" class="product-price">$
                            <?php echo $pizza->getPizzaPrice(); ?>
                        </p>
                        <form class="form-inline add-inputs" method="post" action="../cart/addToCart.php">

                            <input name="PizzaID" type=hidden class="form-control"
                                value="<?php echo $pizza->getPizzaID(); ?>">

                            <?php if (!$isAdmin) { ?>

                                <div class="row">
                                    <div class="col">
                                        <input name="Quantity" id="quantity" class="form-control mb-2" type="Number"
                                            value="1" min="1">
                                    </div>
                                <?php } ?>
                                <div class="col">
                                    <select class="form-control-select" name="Price" id="sizeDropDown"
                                        onchange="updatePrice()">
                                        <?php foreach ($prices as $price): ?>
                                            <option
                                                value='<?php echo json_encode(["size" => $price->getSize(), "price" => $price->getPrice()]) ?>'
                                                data-price="<?php echo $price->getPrice() ?>">
                                                <?php echo $price->getSize() ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <?php if (!$isAdmin) { ?>
                                    <div class="col mt-.5">
                                        <input type="submit" value="Add To Cart" class="btn btn-primary btn-lg"
                                            style="width:100%;">

                                    </div>
                                <?php } ?>
                            </div>
                        </form>



                        <div style="clear: both"></div>

                        <hr>

                        <p class="product-title mt-4 mb-1">About this product</p>
                        <p class="product-description mb-4">
                            <?php echo $pizza->getPizzaDescription(); ?>
                        </p>

                        <hr>
                    </div>

                </div>
            </div>
            <!-- End row -->
        </div>

    </div>
    <script>
        window.onload = function () {
            updatePrice();
        }
        function updatePrice() {
            // Get the selected size dropdown element
            var sizeDropdown = document.getElementById('sizeDropDown');

            // Get the selected option element
            var selectedOption = sizeDropdown.options[sizeDropdown.selectedIndex];

            // Get the price from the data-price attribute of the selected option
            var price = selectedOption.getAttribute('data-price');

            // Update the displayed pizza price
            var priceElement = document.getElementById('lblprice');
            priceElement.innerHTML = '$' + price;
        }
    </script>
</body>

</html>