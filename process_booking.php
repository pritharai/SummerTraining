<?php
include('header.php');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("location:logout.php");
    exit();
}

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$username = $_SESSION['username'];
$con = new mysqli("localhost", "root", "root", "modiste(1)");

// Check the connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Fetch the email from the user table
$sql = "SELECT email FROM user WHERE username = ?";
$stmt = $con->prepare($sql);
if ($stmt === false) {
    die("Prepare failed: " . $con->error);
}
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($email);
$stmt->fetch();
$stmt->close();

// Debugging: Print the fetched email
echo "Fetched mail: $email<br>";

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Debugging: Print the POST data
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    // Validate all required fields
    $requiredFields = ['name', 'startDate', 'endDate', 'totalRentCost', 'totalCost', 'refundAmount', 'quantity'];
    $isValid = true;

    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $isValid = false;
            echo "Missing field: $field<br>";
        }
    }

    if (!$isValid) {
        echo "All fields are required. Please check your form submission.";
        exit();
    }

    // Sanitize and assign POST data
    $productname = htmlspecialchars($_POST['name']);
    $startDate = htmlspecialchars($_POST['startDate']);
    $endDate = htmlspecialchars($_POST['endDate']);
    $totalRentCost = str_replace('Rs.', '', htmlspecialchars($_POST['totalRentCost']));
    $totalCost = str_replace('Rs.', '', htmlspecialchars($_POST['totalCost']));
    $refundAmount = str_replace('Rs.', '', htmlspecialchars($_POST['refundAmount']));
    $quantity = (int) htmlspecialchars($_POST['quantity']);

    // Debugging: Print the sanitized values
    echo "Sanitized Values:<br>";
    echo "Product Name: $productname<br>";
    echo "Start Date: $startDate<br>";
    echo "End Date: $endDate<br>";
    echo "Total Rent Cost: $totalRentCost<br>";
    echo "Total Cost: $totalCost<br>";
    echo "Refund Amount: $refundAmount<br>";
    echo "Quantity: $quantity<br>";

    // Start a transaction
    $con->begin_transaction();

    // Insert into bookings table
    $booking_sql = "INSERT INTO bookings (username, productname, email, start_date, end_date, totalCost) 
                    VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($booking_sql);

    if ($stmt === false) {
        $con->rollback();
        die("Prepare failed: " . $con->error);
    }

    $bind = $stmt->bind_param("ssssss", $username, $productname, $email, $startDate, $endDate, $totalCost);

    if ($bind === false) {
        $con->rollback();
        die("Bind failed: " . $stmt->error);
    }

    if ($stmt->execute()) {
        echo "Booking inserted successfully.<br>";
    } else {
        $con->rollback();
        die("Execute failed: " . $stmt->error);
    }

    $stmt->close();

    // Update the inventory stock directly
    $update_stock_sql = "UPDATE inventory SET stock = stock - ? WHERE productname = ?";
    $stmt = $con->prepare($update_stock_sql);

    if ($stmt === false) {
        $con->rollback();
        die("Prepare failed: " . $con->error);
    }

    $bind = $stmt->bind_param("is", $quantity, $productname);

    if ($bind === false) {
        $con->rollback();
        die("Bind failed: " . $stmt->error);
    }

    if ($stmt->execute()) {
        echo "Inventory updated successfully.<br>";
        $con->commit();
        // Redirect to a thank you page or back to the collection page
        header("Location: thank_you.php");
        exit();
    } else {
        $con->rollback();
        die("Execute failed: " . $stmt->error);
    }

    $stmt->close();
    $con->close();
} else {
    echo "Invalid request method.";
}
?>
