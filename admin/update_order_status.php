<?php
session_start();

// Check if the user is an admin
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$con = new mysqli("localhost", "root", "root", "modiste(1)");

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = $_POST['id'];
    $status = $_POST['status'];

    // Valid status values as per ENUM definition
    $valid_statuses = ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'];

    // Ensure the selected status is valid
    if (!in_array($status, $valid_statuses)) {
        die("Invalid status value.");
    }

    // Update the order status
    $sql = "UPDATE orders SET status=? WHERE id=?";

    // Prepare and bind the statement
    $stmt = $con->prepare($sql);
    $stmt->bind_param("si", $status, $order_id);

    if ($stmt->execute()) {
        echo "<script>alert('Order status updated successfully!'); window.location.href='orders.php';</script>";
    } else {
        echo "Error updating record: " . $con->error;
    }
}

$con->close();
?>
