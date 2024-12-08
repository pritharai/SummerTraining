<?php
include('header.php');
include('connect.php');
// session_start();

// Check if the product_id is provided
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $username = $_SESSION['username'];

    // Delete the job from the database
    $sql = "DELETE FROM carts WHERE product_id='$product_id'";

    if ($con->query($sql) === TRUE) {
        echo '<script>alert("Order deleted successfully.");
             window.location.href="orders.php"</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
} else {
    header("Location: orders.php");
    exit();
}

// Close connection
$con->close();
?>
