<?php
include('header.php');

if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION["email"];
$selected_address_id = $_POST['address_id'] ?? null;

if (!$selected_address_id) {
    die("No address selected.");
}

$con = new mysqli("localhost", "root", "root", "modiste(1)");

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Fetch the selected address details
$address_sql = "SELECT * FROM user_address WHERE address_id = ? AND user_email = ?";
$address_stmt = $con->prepare($address_sql);
$address_stmt->bind_param("is", $selected_address_id, $email);
$address_stmt->execute();
$address_result = $address_stmt->get_result();

if ($address_result->num_rows > 0) {
    $selected_address = $address_result->fetch_assoc();
    $order_message = "Order placed successfully with address: " . htmlspecialchars($selected_address['address']);
} else {
    die("Invalid address selection.");
}

$con->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        p {
            font-size: 1rem;
            color: #555;
            text-align: center;
            line-height: 1.6;
        }
        .btn {
            display: block;
            width: 100%;
            text-align: center;
            background: #28a745;
            color: #fff;
            padding: 10px;
            margin-top: 20px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-size: 1rem;
            cursor: pointer;
        }
        .btn:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <div class="login-nav"></div>
    <div class="container">
        <h1>Order Confirmation</h1>
        <p><?php echo $order_message; ?></p>
        <a href="previous_orders.php" class="btn">Go to Orders</a>
    </div>
</body>
</html>
