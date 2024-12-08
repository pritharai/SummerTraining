<?php
include('header.php');
include('connect.php');
// session_start();

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    // Redirect to the sign-in page if not logged in
    header("Location: logout.php");
    exit();
}

// Check if the address_id is provided
if (isset($_GET['address_id'])) {
    $address_id = $_GET['address_id'];
    $username = $_SESSION['username'];

    // Delete the address from the database
    $sql = "DELETE FROM user_address WHERE address_id='$address_id' AND username='$username'";

    if ($con->query($sql) === TRUE) {
        echo '<script>alert("Address deleted successfully.");
              window.location.href = "address.php";</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
} else {
    header("Location: address.php");
    exit();
}

// Close connection
$con->close();
?>
