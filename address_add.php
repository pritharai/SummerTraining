<?php
include("header.php");
include('connect.php');

if (!isset($_SESSION["username"])) {
    // Redirect to the sign-in page if not logged in
    header("Location: login.php");
    exit();
}

// Get user email from session
$session_email = $_SESSION['email']; // Assuming email is stored in session during login
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Address Page</title>
    <link rel="stylesheet" href="address.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="login-nav"></div>
    <h1 style="text-align:center">Welcome to Modiste</h1>

    <div class="form-container address-form">
        <div class="details">
            <h3 style="text-align: center;">Shipping Address</h3>
            <form action="" method="POST">
                <input type="text" placeholder="Enter your Name" id="name" name="username" required>
                <div class="field">
                    <i class="bi bi-envelope-at"></i>
                    <input type="email" placeholder="Enter Mail ID" id="mail" name="email" value="<?php echo $session_email; ?>" readonly>
                </div>
                <div class="field">
                    <i class="bi bi-telephone-fill form-icon"></i>
                    <input type="tel" placeholder="Enter Contact no." id="contact" name="contact" required>
                </div>
                <textarea name="address" placeholder="Enter address.." required></textarea>
                <input type="text" placeholder="Enter pincode" name="pin" required>
                <label for="country">Country</label>
                <select name="country" id="country" class="select" required>
                    <option value="USA">USA</option>
                    <option value="India">India</option>
                    <option value="England">England</option>
                </select>
                <button type="submit">Enter Address</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
        crossorigin="anonymous">
    </script>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $con->real_escape_string($_POST['username']);
        $contact = $con->real_escape_string($_POST['contact']);
        $address = $con->real_escape_string($_POST['address']);
        $pin = $con->real_escape_string($_POST['pin']);
        $country = $con->real_escape_string($_POST['country']);

        // Validate inputs
        if (empty($username) || empty($contact) || empty($address) || empty($pin) || empty($country)) {
            echo '<script>alert("All fields are required.");</script>';
            exit();
        }

        // Check if the same email and address combination already exists
        $check_sql = "SELECT * FROM user_address WHERE user_email = '$session_email' AND address = '$address'";
        $result = $con->query($check_sql);

        if ($result->num_rows > 0) {
            echo '<script>alert("This address already exists for your email.");</script>';
        } else {
            // Insert new address
            $sql = "INSERT INTO user_address (user_email, username, contact, address, pin, country) 
                    VALUES ('$session_email', '$username', '$contact', '$address', '$pin', '$country')";

            if ($con->query($sql) === TRUE) {
                echo '<script>
                    alert("New address added successfully.");
                    window.location.href = "address.php";
                    </script>';
            } else {
                echo "Error: " . $sql . "<br>" . $con->error;
            }
        }
    }
    $con->close();
    ?>
</body>
</html>
