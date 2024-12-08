<?php
include('header.php');

if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION["email"];
$con = new mysqli("localhost", "root", "root", "modiste(1)");

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Check if the user has addresses
$address_sql = "SELECT * FROM user_address WHERE user_email = ?";
$address_stmt = $con->prepare($address_sql);
$address_stmt->bind_param("s", $email);
$address_stmt->execute();
$address_result = $address_stmt->get_result();

if ($address_result->num_rows > 1) {
    // Redirect to address selection page if multiple addresses are found
    header("Location: select_address.php");
    exit();
} elseif ($address_result->num_rows == 1) {
    // Use the single address for the order
    $address = $address_result->fetch_assoc();
    $selected_address_id = $address['address_id'];
} else {
    // Redirect to add address page if no address is found
    header("Location: address_add.php");
    exit();
}

// Fetch items from the cart
$sql = "SELECT * FROM carts WHERE username = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $_SESSION["username"]);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $total_price = $row['price'] * $row['quantity'];

        // Insert order using prepared statement, including 'price'
        $order_sql = "INSERT INTO orders (username, product_id, productname, quantity, price, total_price, address_id, order_date) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
        $order_stmt = $con->prepare($order_sql);
        $order_stmt->bind_param(
            "sisdisi",
            $_SESSION["username"],
            $row['product_id'],
            $row['productname'],
            $row['quantity'],
            $row['price'],
            $total_price,
            $selected_address_id
        );

        if ($order_stmt->execute()) {
            // Remove product from the cart after confirming the order
            $delete_sql = "DELETE FROM carts WHERE product_id = ? AND username = ?";
            $delete_stmt = $con->prepare($delete_sql);
            $delete_stmt->bind_param("is", $row['product_id'], $_SESSION["username"]);
            $delete_stmt->execute();
        } else {
            echo "Error: " . $order_sql . "<br>" . $con->error;
        }
    }
    echo "<script>alert('Order confirmed successfully!'); window.location.href='orders.php';</script>";
} else {
    echo "No items in the cart.";
}

$con->close();
?>
