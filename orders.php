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
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        .heading {
            text-align: center;
            margin-top: 0px;
            height: 300px;
            background-image: url(./assets/acc_header.jpg);
            background-size: cover;
            background-position: center;
            background-repeat: none;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FEAE6F;
            font-size: 50px;
        }

        .btn-custom {
            border-style: none;
            height: 40px;
            width: 150px;
            background-color: #FE6F77;
            color: aliceblue;
            font-size: 22px;
            cursor: pointer;
            padding-block: 3px;
            margin: 40px auto;
            display: block;
        }

        .btn-custom:hover {
            color: aliceblue;
        }

        .table-responsive {
            margin: 50px auto;
            max-width: 90%;
        }

        .table img {
            max-height: 150px;
            max-width: 100px;
        }

        .table .form-control {
            width: 80px;
        }

        .table .btn {
            margin: 5px 0;
            background-color: #FE6F77;
            color: aliceblue;
            border: none;
        }

        .d-flex {
            display: flex;
        }

        .align-items-center {
            align-items: center;
        }

        .justify-content-center {
            justify-content: center;
        }

        .flex-column {
            flex-direction: column;
        }

        .mb-4 {
            margin-bottom: 1.5rem;
        }

        .checkout-btn {
            background-color: #FE6F77;
            color: aliceblue;
            border: none;
        }

        .checkout-btn:hover {
            color: aliceblue;
        }
        .btn-custom{
            width: 90px;
        }
        .btn-custom:hover{
            background-color: #FE3C47;
        }

    </style>
</head>

<body>
    <div class="login-nav"></div>
    <div class="heading">My Cart</div>
    <?php if (isset($_SESSION["username"])) : ?>
               
        <div class="table-responsive m-5">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Order ID</th>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Discounted Price</th>
                        <th>Quantity</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody style="text-align:center;">
                    <?php
                    $sql = "SELECT * FROM carts WHERE username = '$username'";
                    $result = $con->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td class='mt-5'>" . $row["id"] . "</td>";
                            echo "<td class='mt-5'>" . $row["product_id"] . "</td>";
                            echo "<td class='mt-5'>" . $row["productname"] . "</td>";
                            echo "<td class='mt-5'>Rs." . $row["price"] . "</td>";
                            echo "<td class='mt-5'>" . $row["quantity"] . "</td>";
                            echo "<td><img src='admin/" . $row["image"] . "' alt='product image' height='150px' width='100px'/></td>";
                            echo "<td class='d-flex flex-column align-items-center'>";
                            echo "<a href='delete.php?product_id=" . urlencode($row["product_id"]) . "' class='btn btn-sm btn-custom mb-2'><i class='bi bi-trash3'></i></a>";
                            echo "<a href='buy.php?product_id=" . urlencode($row["product_id"]) . "' class='btn btn-sm btn-custom mb-2'>Buy Now</a>";
                            echo "<form action='edit_quantity.php' method='POST' class='d-flex flex-column align-items-center mb-4'>";
                            echo "<input type='hidden' name='product_id' value='" . $row["product_id"] . "'>";
                            echo "<input type='number' name='quantity' value='" . $row["quantity"] . "' min='1' class='form-control mb-0'>";
                            echo "<button type='submit' class='btn btn-sm btn-custom'>Update</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php if ($result->num_rows > 0) : ?>
            <div class="d-flex justify-content-center">
                <a href="checkout.php" class="btn btn-lg checkout-btn">Checkout</a>
            </div>
        <?php endif; ?>
    <?php else : ?>
        <h1 style="text-align:center; margin-top:20px;">Oops! Not Logged in yet?</h1>
        <button class="btn-custom" onclick="window.location.href='login.php'">Log In</button>
    <?php endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <?php include('footer.php'); ?>
</body>

</html>
<?php
$con->close();
?>
