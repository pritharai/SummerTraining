<?php
include('header.php');
include('connect.php');

// Get the product ID from the URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch data from thrift_items table for the specific product
$sql = "SELECT * FROM thrift_items WHERE id=?";
$stmt = $con->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die("Product not found.");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['item_name']); ?> - Thrift Clothes Online</title>
    <link rel="stylesheet" href="thrift.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        .product-detail {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .product-detail h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 2.5em;
            color: #343a40;
        }
        .product-detail img {
            display: block;
            max-width: 100%;
            height: auto;
            margin: 0 auto 20px;
            border-radius: 10px;
        }
        .product-detail p {
            font-size: 1.1em;
            line-height: 1.6;
            margin-bottom: 10px;
        }
        .product-detail p strong {
            font-weight: bold;
            color: #495057;
        }
    </style>
</head>
<body>
    <div class="login-nav"></div>

    <section id="product-detail" class="product-detail">
        <h2><?php echo htmlspecialchars($product['item_name']); ?></h2>
        <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['item_name']); ?>">
        <p><strong>Description:</strong> <?php echo htmlspecialchars($product['description']); ?></p>
        <p><strong>Price:</strong> $<?php echo htmlspecialchars($product['price']); ?></p>
        <p><strong>Contact:</strong> <?php echo htmlspecialchars($product['phone']); ?></p>
    </section>

    <?php
    include('footer.php');
    ?>

</body>
</html>
<?php
// Close connection
$con->close();
?>
