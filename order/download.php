
<?php
require('fpdf185/fpdf.php');

$orderId = $_GET["OrderID"];
if (empty($orderId)) {
    echo '<p class="text-danger">No Order Detail Available</p>';
} else {
    require_once("orderItem.php");
    require_once("order.php");
    $orderItem = new OrderItem();
    $orders = $orderItem->findAllByOrder($orderId);
    $total = 0;
    foreach ($orders as $item) {
        $total += $item->getPrice() * $item->getQuantity();
    }


    // Create a new PDF object
    $pdf = new FPDF('P','mm','A4');

    // Add a new page
    $pdf->AddPage();

    // Set the font and font size
    $pdf->SetFont('Arial', 'B', 16);

    $pdf->Image('../images/logo.png',10,10,30);

    // Add the company information
    $pdf->Cell(0,10,'Saleways Store',0,1,'R');
    $pdf->Cell(0,10,'123 King Street',0,1,'R');
    $pdf->Cell(0,10,'Waterloo, CA 12345',0,1,'R');
    $pdf->Ln();

    // Set the title of the invoice
    $pdf->Cell(0, 10, 'Invoice for Order #  1KAU9-84UIL', 1, 1, 'C');

    // Add a line break
    $pdf->Ln();

    // Set the font and font size for the table headers
    $pdf->SetFont('Arial', 'B', 12);

    // Add the table headers
    $pdf->Cell(60, 10, 'Product', 1, 0);
    $pdf->Cell(40, 10, 'Price', 1, 0);
    $pdf->Cell(30, 10, 'Quantity', 1, 0);
    $pdf->Cell(40, 10, 'Total', 1, 1);

    // Set the font and font size for the table data
    $pdf->SetFont('Arial', '', 12);

    // Loop through the order items and add them to the table
    foreach ($orders as $item) {
        $pdf->Cell(60, 10, $item->getPizzaName(), 1, 0);
        $pdf->Cell(40, 10, '$' . $item->getPrice(), 1, 0);
        $pdf->Cell(30, 10, $item->getQuantity(), 1, 0);
        $pdf->Cell(40, 10, '$' . $item->getPrice() * $item->getQuantity(), 1, 1);
    }

    // Add a line break
    $pdf->Ln();

    // Add the total amount for the order
    $pdf->Cell(0, 10, 'Total Amount: $' . $total, 0, 1, 'R');

    // Output the PDF
    $pdf->Output();

}
?>