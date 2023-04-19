<!DOCTYPE html>
<html lang="en">
<?php
require_once("orderItem.php");
require_once("order.php");
$order = new Order();
session_start();
if (isset($_SESSION['CustomerID'])) {
    // get the CustomerID value from the session
    $CustomerID = $_SESSION['CustomerID'];
    $orders = $order->findByCustomer($CustomerID);
} else {
    header("Location: ../login/login.php");
    exit;
}

?>


<body>
    <?php require_once("../shared/header.php") ?>
    <div class="container body-content">

        <h2 class="text-center">Order History</h2>
        <table class="table table-hover table table-striped">
            <tbody>
                <tr class="table-primary">
                    <th>OrderID</th>
                    <th>OrderDate</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Action</th>


                </tr>
                <?php if (isset($orders)) { ?>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td class="col-sm-1 col-md-1">#
                                <?php echo $order->getOrderID(); ?>
                            </td>
                            <td class="col-sm-3 col-md-3">
                                <?php echo $order->getOrderDate(); ?>
                            </td>
                            <td class="col-sm-3 col-md-3">
                                <?php echo $order->getShippingAddress(); ?>
                            </td>
                            <td class="col-sm-1 col-md-1"><strong>
                                    <?php echo $order->getStatus(); ?>
                                </strong></td>
                            <td class="col-sm-1 col-md-1 text-center"><strong>$
                                    <?php echo $order->getTotalPrice(); ?>
                                </strong></td>
                            <td class="col-sm-1 col-md-1 text-center">
                                <a href="orderDetails.php?OrderID=<?php echo $order->getOrderID() ?>" css="btn btn-info"
                                    class="btn btn-danger">Details</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php } else { ?>
                    <tr>
                        <td class="text-center" colspan="5">No item in the order </td>
                    </tr>
                <?php } ?>


            </tbody>
        </table>

        <hr>
        <footer>
            <p>© 2023 - Pizza Store Application</p>
        </footer>
    </div>
</body>

</html>