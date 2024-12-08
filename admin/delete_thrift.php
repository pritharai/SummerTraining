<?php
include('header.php');
include('connect.php');

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    // Redirect to the sign-in page if not logged in
    header("Location: logout.php");
    exit();
}

// Check if 'id' is set in the URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize the input to prevent SQL injection

    // Query to delete the item with the specified ID
    $sql = "DELETE FROM thrift_items WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        // Success message
        echo "<script>
            alert('Item deleted successfully.');
            window.location.href = 'thrift.php'; // Redirect back to the items list page
        </script>";
    } else {
        // Error message
        echo "<script>
            alert('Error deleting the item.');
            window.location.href = 'thrift.php';
        </script>";
    }
} else {
    // If 'id' is not set, redirect to the items list page
    header("Location: thrift.php");
    exit();
}

// Close the connection
$con->close();
?>
