<?php
include('header.php');
include('connect.php');

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    // Redirect to the sign-in page if not logged in
    header("Location: login.php");
    exit();
}

// Check if the product ID is provided
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Prepare to delete dependent ratings first
    $delete_ratings_sql = "DELETE FROM ratings WHERE product_id = ?";
    $stmt = $con->prepare($delete_ratings_sql);
    if ($stmt === false) {
        die("Prepare failed: " . $con->error);
    }

    // Bind product ID and execute the delete query for ratings
    $stmt->bind_param("i", $product_id);
    if ($stmt->execute()) {
        // Now proceed to delete the product from the inventory
        $delete_product_sql = "DELETE FROM inventory WHERE product_id = ?";
        $stmt = $con->prepare($delete_product_sql);
        if ($stmt === false) {
            die("Prepare failed: " . $con->error);
        }

        // Bind product ID and execute the delete query for product
        $stmt->bind_param("i", $product_id);
        if ($stmt->execute()) {
            echo '<script>alert("Product and its ratings deleted successfully.");
                  window.location.href = "index.php";</script>';
        } else {
            echo "Error deleting product: " . $stmt->error;
        }
    } else {
        echo "Error deleting ratings: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Product ID is missing.";
}

// Close the connection
$con->close();
?>
