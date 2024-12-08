<?php
include("header.php");

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION["username"];
$con = new mysqli("localhost", "root", "root", "modiste(1)");

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$sql = "SELECT * FROM carts WHERE username = '$username'";
$result = $con->query($sql);

$total_price = 0;
$items = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $total_price += $row['price'] * $row['quantity'];
        $items[] = $row;
    }
} else {
    echo "No items in the cart.";
    exit();
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="login-nav"></div>
    <div class="container mt-5">
        <h1 class="text-center">Confirm Your Order</h1>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Discounted Price</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item) : ?>
                        <tr>
                            <td><?php echo $item['product_id']; ?></td>
                            <td><?php echo $item['productname']; ?></td>
                            <td><?php echo $item['price']; ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo $item['price'] * $item['quantity']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4">Total</th>
                        <th><?php echo $total_price; ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="d-flex justify-content-center">
            <a href="confirm_order.php" class="btn custom-btn btn-md" style="width:10em;">Confirm Order</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
<?php
$con->close();
?>
