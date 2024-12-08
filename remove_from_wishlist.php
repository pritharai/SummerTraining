<?php
// session_start(); // Start the session
include('header.php');
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'] ?? null; // Ensure the product ID is retrieved safely
    $username = $_SESSION["username"]; // Retrieve the username from the session

    if (!$product_id) {
        echo "<script>alert('Product ID is missing.'); window.location.href = 'wishlist.php';</script>";
        exit();
    }

    // Connect to the database
    $con = new mysqli("localhost", "root", "root", "modiste(1)");

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    // Debugging: Check session and product ID
    // var_dump($username, $product_id);

    // Prepare the SQL statement to delete the product from the wishlist
    $sql = "DELETE FROM wishlist WHERE username = ? AND product_id = ?";
    $stmt = $con->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("si", $username, $product_id);

        if ($stmt->execute()) {
            echo "<script>alert('Product removed from wishlist successfully.'); window.location.href = 'wishlist.php';</script>";
        } else {
            echo "<script>alert('Error removing product from wishlist. Please try again.'); window.location.href = 'wishlist.php';</script>";
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $con->error;
    }

    $con->close();
}
?>
