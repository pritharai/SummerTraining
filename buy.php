<?php
include("header.php");

if (!isset($_SESSION["username"])) {
    // Redirect to the sign-in page if not logged in
    header("Location: login.php");
    exit();
}

$username = $_SESSION["username"];
$con = new mysqli("localhost", "root", "root", "modiste(1)");

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Fetch product details from the cart
$product_id = $_GET['product_id'];
$sql = "SELECT * FROM carts WHERE product_id = '$product_id' AND username = '$username'";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
    $total_price = $product['price'] * $product['quantity'];
} else {
    echo "Product not found.";
    exit();
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Confirm Order</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="login-nav"></div>
    <div class="container my-5">
        <h1 class="text-center">Confirm Your Order</h1>
        <div class="card mx-auto" style="width: 30%;">
            <img src="admin/<?php echo $product['image']; ?>" class="card-img-top" alt="Product Image">
            <div class="card-body">
                <h5 class="card-title"><?php echo $product['productname']; ?></h5>
                <p class="card-text">Quantity: <?php echo $product['quantity']; ?></p>
                <p class="card-text">Total Price: $<?php echo $total_price; ?></p>
                <a href="confirm_order.php?pid=<?php echo $product_id; ?>" class="btn custom-btn" style="width:10em;">Confirm Order</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
<?php
$con->close();
?>
