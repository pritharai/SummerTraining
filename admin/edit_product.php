<?php
include('header.php');
include('connect.php');

// session_start(); // Uncomment this to start the session

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    // Redirect to the sign-in page if not logged in
    header("Location: login.php");
    exit();
}

// Check if the product ID is provided
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Fetch record from database
    $sql = "SELECT * FROM inventory WHERE product_id='$product_id'";
    $result = $con->query($sql);

    if (!$result) {
        echo "Error fetching product: " . $con->error;
        exit();
    }

    $row = $result->fetch_assoc();

    if (!$row) {
        echo "Product not found or you do not have permission to edit this product.";
        exit();
    }

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect and escape form data
        $productname = mysqli_real_escape_string($con, $_POST['productname']);
        $description = mysqli_real_escape_string($con, $_POST['description']);
        $original_price = mysqli_real_escape_string($con, $_POST['original_price']);
        $price = mysqli_real_escape_string($con, $_POST['price']);

        // Update data in the database
        $sql = "UPDATE inventory SET 
                productname='$productname', 
                description='$description', 
                original_price='$original_price', 
                price='$price'  
                WHERE product_id='$product_id'";

        if ($con->query($sql) === TRUE) {
            echo '<script>alert("Product updated successfully.");
                  window.location.href = "index.php";</script>';
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    }
} else {
    header("Location: index.php");
    exit();
}

// Close connection
$con->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="login-nav"></div>

    <h3 style="text-align: center;" classs="">Product Details</h3>
    <div class="product-edit-form">
        <div class="prod-img">
            <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="" width="350px" height="400px" class="prod-img">
        </div>

        <div class="details">
            <form action="" method="POST">
                <input type="text" id="name" name="productname" value="<?php echo htmlspecialchars($row['productname']); ?>" readonly>
                <div class="field"><i class=""></i><input type="text" placeholder="Enter product description" id="description" name="description" value="<?php echo htmlspecialchars($row['description']); ?>"></div>
                <div class="field"><i class=""></i><input type="number" placeholder="Enter original price" id="original_price" name="original_price" value="<?php echo htmlspecialchars($row['original_price']); ?>"></div>
                <div class="fields"><input type="number" name="price" placeholder="Enter discounted price" value="<?php echo htmlspecialchars($row['price']); ?>"></div>
                <button class="btn" type="submit">Update Product</button>
            </form>
        </div>
    </div>
</body>

</html>
