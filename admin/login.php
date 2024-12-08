<?php
//    session_start();
   include("header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./style.css" type="css">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="login-nav">

    </div>
    <div class="form-container">
        <div class="details">
            <h1>Welcome!</h1>
            <form action="" method="post">
                <input type="text" placeholder="Your name" id="username" name="username" required>
                <input type="password" placeholder="Your password" name="password" id="password" required>
                <p>Lost your password?</p>
                <button class="btn" value="Login">Log In</button>
                
            </form>
        </div>
        <div class="side-img">
            <img src="../assets/bg3.jpg" alt="">
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    
</body>
</html>
<?php


$con = new mysqli("localhost", "root", "root", "modiste(1)");

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Prepared statement to prevent SQL injection
    $stmt = $con->prepare("SELECT * FROM admin WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);  // "ss" means two string parameters
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION["username"] = $username;  // Store the session
        header("Location: index.php");  // Redirect after successful login
        exit();
    } else {
        echo '<script>alert("Invalid credentials.")</script>';
    }

    $stmt->close();
}

$con->close();
?>
