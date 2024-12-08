<?php
include('connect.php');
include('header.php');

if (!isset($_SESSION['username'])){
    echo "Session 'username' not set.";
    // header("location:logout.php");
}

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_name = htmlspecialchars($_POST['item_name']);
    $description = htmlspecialchars($_POST['description']);
    $price = htmlspecialchars($_POST['price']);
    $phone = htmlspecialchars($_POST['phone']);
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);

    // Check if uploads directory exists
    if (!is_dir('uploads')) {
        mkdir('uploads', 0755, true);
    }

    // Upload image to server
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        // Prepare and bind
        $stmt = $con->prepare("INSERT INTO thrift_items (item_name, description, price, phone, image) VALUES (?, ?, ?, ?, ?)");
        if ($stmt === false) {
            die("Prepare failed: " . $con->error);
        }

        $bind = $stmt->bind_param("ssiss", $item_name, $description, $price, $phone, $image);
        if ($bind === false) {
            die("Bind failed: " . $stmt->error);
        }

        // Execute the query
        if ($stmt->execute()) {
            // Redirect to a thank you page or back to the form with a success message
            header("Location: thrift_success.php");
            exit();
        } else {
            die("Execute failed: " . $stmt->error);
        }

        // Close the statement and connection
        $stmt->close();
        $con->close();
    } else {
        echo "Failed to upload image.";
    }
} else {
    echo "Invalid request method.";
}
?>
