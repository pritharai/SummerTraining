<?php
// session_start();
include('header.php');

if (!isset($_SESSION["username"])) {
    // Redirect to login if the user is not authenticated
    header("Location: logout.php");
    exit();
}

include('connect.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thrift Upload Success</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="thrift.css">
    <style>
        body {
            
            background-color: #f8f9fa;
          
           
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .success-container {
            text-align: center;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 50em;
            margin: 100px 350px;
        }

        .success-container h1 {
            color: #28a745;
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .success-container p {
            font-size: 1rem;
            color: #333;
            margin-bottom: 20px;
        }

        .success-container a {
            text-decoration: none;
            margin: 5px;
        }
        .login-nav{
    background-color: #F6995C;
    height: 100px;
    margin-top: -5%;
}

        /* .btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 10px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        } */
        /* .heading {
            text-align: center;
            margin-top: 0px;
            height: 350px;
            background-image: url(./assets/thrifted6.avif);
            background-size: cover;
            background-position: center;
            background-repeat: none;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FEAE6F;
            font-size: 50px;
        } */
        /* .custom-btn{
            margin-left: 30%;
        } */
    </style>
</head>

<body>
    <div class="login-nav"></div>
    <div class="success-container">
        <div class="heading"><h1>Success!</h1></div>
        <p>Your item has been uploaded to the thrift section.</p>
        <a href="sell.php" class="btn">Upload Another Item</a>
        <a href="thrift.php" class="btn">Go to Store</a>
    </div>
    
</body>
<?php
include('footer.php');
?>

</html>

