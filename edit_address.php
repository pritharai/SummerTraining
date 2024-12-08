<?php
include('header.php');

if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

include('connect.php');

// Get address ID from query parameter
$address_id = $_GET['address_id'] ?? null;

if (!$address_id) {
    die("Invalid address ID.");
}

// Fetch the existing address details from the database
$sql = "SELECT * FROM user_address WHERE address_id = ? AND user_email = ?";
if ($stmt = mysqli_prepare($con, $sql)) {
    mysqli_stmt_bind_param($stmt, "is", $address_id, $_SESSION["email"]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Use htmlspecialchars to sanitize output
        $username = htmlspecialchars($row["username"] ?? "Not provided");
        $contact = htmlspecialchars($row["contact"] ?? "Not provided");
        $address = htmlspecialchars($row["address"] ?? "Not provided");
        $pin = htmlspecialchars($row["pin"] ?? "Not provided");
        $country = htmlspecialchars($row["country"] ?? "Not provided");
    } else {
        die("Address not found or you don't have permission to edit it.");
    }

    mysqli_stmt_close($stmt);
} else {
    die("Error preparing SQL statement: " . mysqli_error($con));
}

// If the form is submitted, handle the update logic
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $new_username = $_POST["username"];
    $new_contact = $_POST["contact"];
    $new_address = $_POST["address"];
    $new_pin = $_POST["pin"];
    $new_country = $_POST["country"];

    $update_sql = "UPDATE user_address SET username = ?, contact = ?, address = ?, pin = ?, country = ? WHERE address_id = ? AND user_email = ?";
    if ($update_stmt = mysqli_prepare($con, $update_sql)) {
        mysqli_stmt_bind_param($update_stmt, "sssssis", $new_username, $new_contact, $new_address, $new_pin, $new_country, $address_id, $_SESSION["email"]);
        if (mysqli_stmt_execute($update_stmt)) {
            echo "Address updated successfully.";
            header("Location: address.php");
            exit();
        } else {
            echo "Failed to update address: " . mysqli_error($con);
        }

        mysqli_stmt_close($update_stmt);
    } else {
        die("Error preparing SQL statement: " . mysqli_error($con));
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Address</title>
    <link rel="stylesheet" href="address.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    /* display: flex; */
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

form {
    background: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    padding: 20px 30px;
    width: 800px;
    margin: 100px auto;
}

form label {
    display: block;
    font-weight: bold;
    margin-bottom: 0px;
    color: #333;
}

form input[type="text"],
form textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 5px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

form textarea {
    resize: none;
    height: 100px;
}

form button {
    width: 100%;
    padding: 10px;
    /* background-color: #007bff; */
    border: none;
    border-radius: 4px;
    color: white;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

form button:focus {
    outline: none;
    box-shadow: 0 0 4px #007bff;
}
.btn{
    background-color: #FEAE6F;
}

    </style>
</head>
<body>
    <div class="login-nav"></div>
    <form method="POST">
        <label for="username">Name:</label>
        <input type="text" id="username" name="username" value="<?php echo $username; ?>" required><br>
        <label for="contact">Contact:</label>
        <input type="text" id="contact" name="contact" value="<?php echo $contact; ?>" required><br>
        <label for="address">Address:</label>
        <textarea id="address" name="address" required><?php echo $address; ?></textarea><br>
        <label for="pin">Pin Code:</label>
        <input type="text" id="pin" name="pin" value="<?php echo $pin; ?>" required><br>
        <label for="country">Country:</label>
        <input type="text" id="country" name="country" value="<?php echo $country; ?>" required><br>
        <button type="submit" class="btn">Update Address</button>
    </form>
</body>
<?php 
include('footer.php');
?>
</html>
<?php
// Close the database connection
mysqli_close($con);
?>
