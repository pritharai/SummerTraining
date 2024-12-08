<?php
include("connect.php");
session_start();

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // $name = htmlspecialchars($_POST['name']);
    $username = $_SESSION['username'];
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Prepare and bind
    $stmt = $con->prepare("INSERT INTO rent_contact_form (username, email, message) VALUES (?, ?, ?)");
    if ($stmt === false) {
        die("Prepare failed: " . $con->error);
    }

    $bind = $stmt->bind_param("sss", $username, $email, $message);
    if ($bind === false) {
        die("Bind failed: " . $stmt->error);
    }

    // Execute the query
    if ($stmt->execute()) {
        // Redirect to a thank you page or back to the contact page with a success message
        header("Location: contact_thank_you.php");
        exit();
    } else {
        die("Execute failed: " . $stmt->error);
    }

    // Close the statement and connection
    $stmt->close();
    $con->close();
} else {
    echo "Invalid request method.";
}
?>
