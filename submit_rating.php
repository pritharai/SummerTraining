<?php
include('connect.php');
include('header.php');
// session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['username']) || !isset($_SESSION['email'])) {
        header("location: logout.php");
        exit();
        
    }

    $username = $_SESSION['username'];
    $user_mail = $_SESSION['email'];
    $product_id = $_POST['product_id'];
    $rating = $_POST['rating'];

    // Check if the user has already rated this product
    $sql = "SELECT * FROM ratings WHERE user_mail = ? AND product_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('si', $user_mail, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update the existing rating
        $sql = "UPDATE ratings SET rating = ?, username = ? WHERE user_mail = ? AND product_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('issi', $rating, $username, $user_mail, $product_id);
    } else {
        // Insert a new rating
        $sql = "INSERT INTO ratings (user_mail, username, product_id, rating) VALUES (?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('ssii', $user_mail, $username, $product_id, $rating);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Rating submitted successfully');</script>";
        header("Location: shop_product_details.php?product_id=" . $product_id); // Redirect to the product details page
        exit();
    } else {
        echo "<script>alert('Error submitting rating');</script>";
    }
}


$con->close();
?>
