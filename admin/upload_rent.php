<?php
include('header.php');

if (!isset($_SESSION["username"])) {
    // Redirect to the sign-in page if not logged in
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "modiste(1)";

$con = new mysqli($servername, $username, $password, $dbname);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dressName = $con->real_escape_string($_POST["productname"]);
    $dressDescription = $con->real_escape_string($_POST["description"]);
    $dressPrice = $con->real_escape_string($_POST["price"]);
    // $securityCost = $con->real_escape_string($_POST["securityCost"]);
    
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Check if file is an image
    // $check = getimagesize($_FILES["dressImage"]["tmp_name"]);
    // if ($check === false) {
    //     echo "File is not an image.";
    //     exit();
    // }

    // Check file size (5MB max)
    if ($_FILES["dressImage"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        exit();
    }

    // Allow certain file formats
    // if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    //     echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    //     exit();
    // }

    if (move_uploaded_file($_FILES["dressImage"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO inventory (productname, description, price, image) VALUES ('$productame', '$description', '$price', '$target_file')";
        
        if ($con->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$con->close();
?>
