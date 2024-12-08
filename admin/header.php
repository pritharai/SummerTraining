<?php
include('connect.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <nav>
        <div class="nav-logo">
            MODISTE
        </div>
        <div class="nav-menu">
            <a href="index.php">Home</a>
            <a href="shop.php">Shop</a>
            <a href="rent.php">Rentals</a>
            <a href="thrift.php">Thrift</a>
            <a href="orders.php">Orders</a>
        </div>
        <div class="side-menu">
        
            
            <?php if (isset($_SESSION["username"])): ?>
            <a href="logout.php"><i class="bi bi-person-circle"></i></a>
            <!-- <a href="logout.php"><i class="bi bi-box-arrow-right"></i></a> -->
            <?php else: ?>
            <a href="login.php"><i class="bi bi-person-circle"></i></a>
            <?php endif; ?>
        </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>