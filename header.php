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
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="offcanvas.css">
</head>

<body>
  <nav>
    <div class="nav-logo">
     <a style="text-decoration:none; color:aliceblue;" href="index.php">MODISTE</a>
    </div>
    <div class="nav-menu">
      <a href="index.php">Home</a>
      <a href="shop.php">Shop</a>
      <a href="rent.php">Rentals</a>
      <a href="thrift.php">Thrift</a>
    </div>
    <div class="side-menu">
      <a class="search link-light px-0 fs-4 mt-1" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop" aria-controls="offcanvasTop"><i class="bi bi-search"></i></a>
      <?php if (isset($_SESSION["username"])) : ?>
        <a href="wishlist.php"><i class="bi bi-bag-heart"></i></a>
        <a href="orders.php"><i class="bi bi-cart3"></i></a>
        <a href="account.php"><i class="bi bi-person-circle"></i></a>
        <a href="logout.php"><i class="bi bi-box-arrow-right"></i></a>
      <?php else : ?>
        <a href="login.php"><i class="bi bi-person-circle"></i></a>
      <?php endif; ?>
    </div>
  </nav>

  <!-- Offcanvas HTML outside the link -->
  <div class="offcanvas offcanvas-top" tabindex="-1" id="offcanvasTop" aria-labelledby="offcanvasTopLabel" style="height:300px;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasTopLabel">Search</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="search-container">
            <h1 class="text-center mb-4">Search Products</h1>
            <form action="search.php" method="GET" class="search-form">
                <input type="text" name="query" placeholder="Enter product name or description" required class="form-control mb-3">
                <button type="submit" class="btn w-100">Search</button>
            </form>
            <div class="search-results mt-4">
                <!-- Results will be displayed here -->
            </div>
        </div>
    </div>
</div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
