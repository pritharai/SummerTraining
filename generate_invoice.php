<?php
require('fpdf/fpdf.php');
include('connect.php');

session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$id = $_GET['id'];

// Fetch order details for the given order_id and username
$sql = "SELECT orders.id, orders.product_id, orders.quantity, orders.total_price, orders.order_date, orders.status, inventory.productname as productname, user.username as username, user_address.address, user_address.contact 
        FROM orders 
        JOIN inventory ON orders.product_id = inventory.product_id 
        JOIN user ON orders.username = user.username 
        JOIN user_address ON user.username = user_address.username 
        WHERE orders.username = ? AND orders.id = ?";
$stmt = $con->prepare($sql);

if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($con->error));
}

$stmt->bind_param("si", $username, $id);

if ($stmt->execute() === false) {
    die('Execute failed: ' . htmlspecialchars($stmt->error));
}

$result = $stmt->get_result();
$order = $result->fetch_assoc();

if (!$order) {
    die("Order not found.");
}

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Invoice', 0, 1, 'C');
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Order ID: ' . $order['id'], 0, 1);
$pdf->Cell(0, 10, 'Product Name: ' . $order['productname'], 0, 1);
$pdf->Cell(0, 10, 'Quantity: ' . $order['quantity'], 0, 1);
$pdf->Cell(0, 10, 'Total Price: Rs.' . $order['total_price'], 0, 1);
$pdf->Cell(0, 10, 'Order Date: ' . $order['order_date'], 0, 1);
$pdf->Cell(0, 10, 'Status: ' . $order['status'], 0, 1);
$pdf->Cell(0, 10, 'User Name: ' . $order['username'], 0, 1);
$pdf->Cell(0, 10, 'Address: ' . $order['address'], 0, 1);
$pdf->Cell(0, 10, 'Alternate Contact: ' . $order['contact'], 0, 1);

$pdf->Output('D', 'invoice_' . $order['id'] . '.pdf');

$stmt->close();
$con->close();
?>
