<!DOCTYPE html>
<html lang="en">
    
<?php
$orderId = $_GET["OrderID"];
if (empty($orderId)) {
    echo '<p class="text-danger">No Order Detail Available</p>';
} else {
    require_once("orderItem.php");
    $order = new OrderItem();
    $orders = $order->findAllByOrder($orderId);
    $total = 0;
    foreach ($orders as $item) {
        $total += $item->getPrice() * $item->getQuantity();
    }
}
?>
<body>
<?php require_once("../shared/header.php") ?>

<div class="container body-content">
            

    <div class="container-fluid my-5  d-flex  justify-content-center">
        <div class="card card-1">
            <div class="card-header bg-white">
                <div class="media flex-sm-row flex-column-reverse justify-content-between  ">
                    <div class="col my-auto">
                        <h4 class="mb-0">Your Order Details!</h4>
                    </div>
                    <div class="col-auto text-center  my-auto pl-0 pt-sm-4">
                        <p class="mb-4 pt-0">Ordered Pizza</p>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row justify-content-between mb-3">
                    <div class="col-auto">
                        <h6 class="color-1 mb-0 change-color">Receipt</h6>
                    </div>
                    <div class="col-auto  "><small>Receipt Voucher : 1KAU9-84UIL</small> </div>
                </div>
                <?php foreach ($orders as $rowOrder): ?>
                        <div class="row">
                            <div class="col mt-2">
                                <div class="card card-2">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="sq align-self-center ">
                                                <img class="img-fluid  my-auto align-self-center mr-2 mr-md-4 pl-0 p-0 m-0" src="../admin/pizza/images/<?php echo $rowOrder->getPizzaImage(); ?>" width="135" height="135">
                                            </div>
                                            <div class="media-body my-auto text-right">
                                                <div class="row  my-auto flex-column flex-md-row">
                                                    <div class="col my-auto">
                                                        <h6 class="mb-0"><?php echo $rowOrder->getPizzaName() ?></h6>
                                                    </div>
                                                    <div class="col my-auto"><small>Qty : <?php echo $rowOrder->getQuantity() ?></small></div>
                                                    <div class="col my-auto">
                                                        <h6 class="mb-0">$<?php echo $rowOrder->getPrice() ?></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="my-3 ">
                                        <div class="row">
                                            <div class="col-md-3 mb-3"><small>Track Order <span><i class=" ml-2 fa fa-refresh" aria-hidden="true"></i></span></small></div>
                                            <div class="col mt-auto">
                                                <div class="progress my-auto">
                                                    <div class="progress-bar progress-bar  rounded" style="width: 62%" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <div class="media row justify-content-between ">
                                                    <div class="col-auto text-right"><span><small class="text-right mr-sm-2"></small><i class="fa fa-circle active"></i></span></div>
                                                    <div class="flex-col"><span><small class="text-right mr-sm-2">Out for delivary</small><i class="fa fa-circle active"></i></span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
            
            </div>
            <div class="card-footer">
                <div class="jumbotron-fluid">
                    <div class="row justify-content-between ">
                        <div class="col-sm-auto col-auto my-auto">
                        </div>
                        <div class="col-auto my-auto ">
                            <h2 class="mb-0 font-weight-bold">TOTAL PAID</h2>
                        </div>
                        <div class="col-auto my-auto ml-auto">
                            <span id="MainContent_lblTotal" class="h1 display-3">$<?php echo  $total ?></span>
                        </div>
                    </div>
            
                </div>
            </div>
            <a class="btn btn-primary" href="download.php?OrderID=<?php echo $orderId ?>">Download</a>
        </div>
    </div>


            <hr>
            <footer>
                <p>© 2023 - Pizza Store Application</p>
            </footer>
        </div>

</body>
</html>