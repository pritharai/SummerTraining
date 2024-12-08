<?php
// add_to_cart.php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];  // Retrieve the quantity from POST data
    $username = $_SESSION["username"];
    $con = new mysqli("localhost", "root", "root", "modiste(1)");

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    // Fetch product details to get the image, price, and name from the inventory table
    $sql = "SELECT image, price, productname FROM inventory WHERE product_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $image = $row['image'];
        $price = $row['price'];
        $productname = $row['productname'];

        // Check if the product is already in the cart
        $sql = "SELECT id, quantity FROM carts WHERE username = ? AND product_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $username, $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Update the quantity if the product is already in the cart
            $row = $result->fetch_assoc();
            $id = $row['id'];
            $current_quantity = $row['quantity'];
            $new_quantity = $current_quantity + $quantity;

            $sql = "UPDATE carts SET quantity = ? WHERE id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ii", $new_quantity, $id);
            if ($stmt->execute()) {
                echo "<script>alert('Product quantity updated in the cart successfully');</script>";
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            // Insert the product into the cart
            $sql = "INSERT INTO carts (username, product_id, productname, quantity, image, price) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("sissss", $username, $product_id, $productname, $quantity, $image, $price);

            if ($stmt->execute()) {
                echo "<script>alert('Product added to cart successfully');</script>";
            } else {
                echo "Error: " . $stmt->error;
            }
        }
    } else {
        echo "<script>alert('Product not found.');</script>";
    }

    $stmt->close();
    $con->close();

    // Redirect to orders or another page if needed
    header("Location: orders.php");
    exit();
}
?>
