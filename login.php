<?php
// session_start(); // Start session at the very beginning

include('header.php'); // Include dependencies
include('connect.php'); // Include database connection

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];

    // Prepared statement for security
    $sql = "SELECT * FROM user WHERE (username = ? AND email = ?) AND password = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $password); // 'sss' means three string parameters
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Set session variables
        $_SESSION["username"] = $username;
        $_SESSION["email"] = $email;

        // Redirect after successful login
        header("Location: index.php");
        exit(); // Stop further script execution after redirect
    } else {
        echo '<script>alert("Invalid credentials.");</script>';
    }
}

$con->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .container {
            display: flex;
        }
        .section {
            border-radius: 10px;
            width: 45%;
            gap: 10px;
            padding: 5px;
            margin-inline: 5px;
        }
    </style>
</head>
<body>
    <div class="login-nav"></div>
    <div class="form-container">
        <div class="details">
            <h1>Welcome!</h1>
            <form action="" method="post">
                <input type="text" placeholder="Your name" id="username" name="username" required>
                <input type="email" placeholder="Your email" id="email" name="email" required>
                <input type="password" placeholder="Your password" name="password" id="password" required>
                <p>Lost your password?</p>
                <button class="btn" value="Login">Log In</button>
            </form>
            <div class="container">
                <div class="section">
                    <h3 style="text-align:center">First visit to Modiste?</h3>
                    <button class="btn" onclick="window.location.href='signup.php'">Sign Up</button>
                </div>
                <div class="section">
                    <h3 style="text-align:center">Enter as Admin</h3>
                    <button class="btn" value="Login">Login</button>
                </div>
            </div>
        </div>
        <div class="side-img">
            <img src="./assets/bg2.webp" alt="">
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
