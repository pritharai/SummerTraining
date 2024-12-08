<?php
include('header.php');
include('connect.php');

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["username"]) || !isset($_SESSION["email"])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit();
}

$username = $_SESSION["username"];
$email = $_SESSION["email"];

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection check
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Address</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="address.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="login-nav"></div>
    <h1><?php echo htmlspecialchars($username); ?>'s Address</h1>

    <a href="address_add.php" class="btn btn-md btn-primary mx-5">Add New Address</a>

    <div class="address-main-container">
        <?php
        // Query to fetch addresses linked to the logged-in user's email
        $sql = "SELECT * FROM user_address WHERE user_email = ?";

        // Prepare the statement
        if ($stmt = mysqli_prepare($con, $sql)) {
            // Bind the email parameter
            mysqli_stmt_bind_param($stmt, "s", $email);

            // Execute the query
            mysqli_stmt_execute($stmt);

            // Fetch the result
            $result = mysqli_stmt_get_result($stmt);

            // Check if addresses exist
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // Each address will have its own container
                    echo "<div class='address-container'>";
                    echo "<div class='address-card'>";
                    echo "<p><strong>Name: </strong>" . htmlspecialchars($row["username"]) . "</p>";
                    echo "<p><strong>Email: </strong>" . htmlspecialchars($row["user_email"]) . "</p>";
                    echo "<p><strong>Contact: </strong>" . htmlspecialchars($row["contact"]) . "</p>";
                    echo "<p><strong>Address: </strong>" . htmlspecialchars($row["address"] ?? "Not provided") . "</p>";
                    echo "<p><strong>Pin Code: </strong>" . htmlspecialchars($row["pin"] ?? "Not provided") . "</p>";
                    echo "<p><strong>Country: </strong>" . htmlspecialchars($row["country"] ?? "Not provided") . "</p>";
                    echo "</div>";
                    echo "<div class='action-buttons'>";
                    echo "<a href='edit_address.php?address_id=" . urlencode($row["address_id"]) . "' class='btn btn-md btn-info custom-btn'>Edit</a>";
                    echo "<a href='delete_address.php?address_id=" . urlencode($row["address_id"]) . "' class='btn btn-md btn-danger custom-btn'>Delete</a>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                // No addresses found
                echo "<p>Hi " . htmlspecialchars($username) . ", you haven't added any addresses yet. Would you like to <a href='address_add.php'>add one</a>?</p>";
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            // Error preparing statement
            echo "Error: " . mysqli_error($con);
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
<?php
// Close the database connection
mysqli_close($con);
?>
