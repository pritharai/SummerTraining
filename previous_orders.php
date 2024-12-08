<?php
include('header.php');
// include('connect.php');

// session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch orders for the logged-in user
$sql = "SELECT orders.id, orders.product_id, orders.quantity, orders.total_price, orders.order_date, orders.status, inventory.productname as productname, inventory.image as product_image FROM orders JOIN inventory ON orders.product_id = inventory.product_id WHERE orders.username = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $username); // Bind the username as a string
$stmt->execute();
$result = $stmt->get_result();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        .heading {
            text-align: center;
            margin-top: 0px;
            height: 300px;
            background-image: url(./assets/shop_header.avif);
            background-size: cover;
            background-position: center;
            background-repeat: none;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FEAE6F;
            font-size: 50px;
        }
        .product-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .card {
            max-width: 450px;
            margin: 15px;
        }
    </style>
</head>

<body>
    <div class="login-nav"></div>
    <h1 class="heading">My Orders</h1>
    <div class="product-container mt-5 align-">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card mb-3 mx-3">';
                echo '<img src="admin/' . $row["product_image"] . '" class="img-fluid rounded-start" alt="...">';
                echo '<div class="col-md-9">';
                echo '<div class="card-body text-center">';
                echo '<p class="card-title">' . $row["productname"] . '</p>';
                echo '<p class="card-text">Total Price: Rs.' . $row["total_price"] . '</p>';
                echo '<p class="card-text">Status: ' . $row["status"] . '</p>';
                echo '<a href="generate_invoice.php?id=' . $row["id"] . '" class="btn btn-primary">Download Invoice</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>No orders found.</p>';
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <?php
    include('footer.php');
    ?>
</body>

</html>

<?php
$stmt->close();
$con->close();
?>
