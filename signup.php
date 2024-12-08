<?php
include("header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <link rel="stylesheet" href="style.css" type="css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="login-nav"></div>
    <div class="form-container">
        <div class="details">
            <h1>Welcome to Modiste</h1>
            <form method="post">
                <input type="text" placeholder="Enter your Name" id="name" name="username" required>
                <!-- <input type="text" placeholder="Last Name" id="Lname" name="Lname"> -->
                <div class="field"><i class="bi bi-envelope-at"></i><input type="email" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Enter Mail ID" id="email" name="email" required></div>
                <div class="field"><i class="bi bi-telephone-fill form-icon"></i><input type="tel" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Enter Contact no." id="contact" name="contact" required></div>
                <input type="password" placeholder="Password must be of 8-12 characters" id="password" name="password" required>
                <div class="gender-select">
                    <label for="gender">Gender:&nbsp;&nbsp;&nbsp;&nbsp; </label>
                    <label for="female">Female</label>
                    <input type="radio" name="gender" id="female">
                    <label for="male">Male</label>
                    <input type="radio" name="gender" id="male">
                    <label for="other">Other</label>
                    <input type="radio" name="gender" id="other">
                </div>
                <button class="btn" value="create" onclick="window.location.href='address.php'">Hop On!</button>
            </form>
        </div>
        <div class="side-img">
            <img src="./assets/bg3.jpg" alt="">
        </div>
        

    </div>
</body>
</html>
<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "modiste(1)";

// Create conection
$con = mysqli_connect($servername, $username, $password, $dbname);

// Check Connection
if($con->connect_error){
    die("Connection Failed:" . $con->connect_error);
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST['username'];
    // $LName = $_POST['Lname'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $password = $_POST['password'];
    $check_sql = "SELECT * FROM user WHERE username = '$username' AND email = '$email'";
    $result = $con->query($check_sql);
    if ($result->num_rows > 0) {
        echo '<script>
        alert("User already exists");
        </script>';
    } else {

          $sql = "INSERT INTO user (username, email, contact, password) VALUES ('$username', '$email', '$contact', '$password')"; 

        if($con-> query($sql) === TRUE){
        // echo "New Record created successfully";
        echo '<script>
        alert("New Record created successfully");
        window.location.href = "login.php";
        </script>';
        }else {
        echo "Error: " . $sql . "<br>" . $con->error;
        }
    }
}
$con->close();
?>


