<?php
include('header.php');
include("connect.php");

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    // Redirect to the sign-in page if not logged in
    header("Location: login.php");
    exit();
}

// Fetch data from database
$sql = "SELECT * FROM inventory";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link rel="stylesheet" href="admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="login-nav"></div>
    <div class="container">
        <h1 class="mt-4 mb-4">All Products</h1>
        <a href="products.php"><button class="btn btn-primary mb-3">New Record</button></a>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Product ID</th>
                        <th>Product Category</th>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Cost</th>
                        <th>Discounted Price</th>
                        <th>Stock</th>
                        <th>Img</th>
                       
                    </tr>
                </thead>
                <tbody style="text-align:center;" >
                    <?php
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td classs='mt-5'>" . $row["product_id"] . "</td>";
                            echo "<td classs='mt-5'>" . $row["category"] . "</td>";
                            // echo "<td classs='mt-5'>" . $row["pid"] . "</td>";
                            echo "<td classs='mt-5'>" . $row["productname"] . "</td>";
                            echo "<td classs='mt-5'>" . $row["description"] . "</td>";
                            echo "<td classs='mt-5'>" . $row["original_price"] . "</td>";
                            echo "<td classs='mt-5'>" . $row["price"] . "</td>";
                            echo "<td classs='mt-5'>" . $row["stock"] . "</td>";
                            echo "<td><img src='".$row["image"]."' alt='sorry' height='240px' width='180px'/></td>";
                            echo "<td>";
                            echo "<a href='edit_product.php?product_id=" . $row["product_id"] . "' class='btn btn-sm btn-info'>Edit</a>";
                            echo "<a href='delete_product.php?product_id=" . $row["product_id"] . "' class='btn btn-sm btn-danger'>Delete</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
<?php
// Close connection
$con->close();
?>
