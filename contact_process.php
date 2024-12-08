<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all the fields are filled
    if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['message'])) {
        echo "Please fill in all the fields.";
        exit();
    }

    // Sanitize user inputs
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Prepare and bind the SQL statement
    $stmt = $con->prepare("INSERT INTO contact_us (username, email, message) VALUES (?, ?, ?)");

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
        header("Location: contact.php?status=success");
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
