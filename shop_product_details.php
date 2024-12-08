<?php
include('header.php');
include('connect.php');

$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

// Fetch product details
$sql = "SELECT * FROM inventory WHERE product_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param('i', $product_id);
$stmt->execute();
$product_result = $stmt->get_result();
$product = $product_result->fetch_assoc();

if (!$product) {
    die("Product not found.");
}

// Fetch average rating
$sql = "SELECT AVG(rating) AS average_rating FROM ratings WHERE product_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param('i', $product_id);
$stmt->execute();
$rating_result = $stmt->get_result();
$rating = $rating_result->fetch_assoc();

$average_rating = $rating['average_rating'] ? number_format($rating['average_rating'], 1) : 'No ratings yet';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['productname']); ?> - Product Details</title>

    <link rel="stylesheet" href="style.css">
    <style>
        /* Your custom styles here */
        .product-details-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            max-width: 900px;
            position: relative;
        }

        .product-details-container img {
            max-width: 100%;
            border-radius: 8px;
        }

        .cont {
            flex: 1;
            padding: 20px;
        }

        .cont h1 {
            margin-bottom: 20px;
            font-size: 2rem;
            color: #333;
        }

        .cont p {
            margin: 10px 0;
            font-size: 1.1rem;
            color: #555;
            margin-top: 20px;
        }

        .average-rating {
            margin: 20px 0;
            font-size: 1.2rem;
            font-weight: bold;
            margin-top: 70%;

        }
        .average-rating p{
            position: absolute;
        }

        .rating-form {
            margin-top: 20px;
        }


        .rating-form label {
            font-size: 1.1rem;
            margin-right: 10px;
        }

        .rating-form select {
            padding: 5px;
            font-size: 1rem;
            width: 200px;
        }

        .rating-form .btn {
            padding: 8px 15px;
            background-color: brown;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }

        .rating-form .btn:hover {
            background-color: #fe996c;
        }
        .btn-list{
            display: flex;
            flex-direction: row;
        }
        .wishlist-btn{
            position: absolute;
            margin-top: 10%;
            width: 200px;
            background-color: brown;
            height: 40px;
            margin-left: 2%;

        }
        .cart-btn{
            position: absolute;
            margin-top:10%;
            margin-left: -7%;
            
        }
        .btn{
            width: 200px;
            background-color: brown;
            height: 40px;

        }
        .add-to-cart-form input[type="number"]{
            position: absolute;
            width: 200px;
            /* margin-top: %; */
            margin-left: 2%;

        }

    </style>
</head>
<body>
    <div class="login-nav"></div>
    <div class="product-details-container">
        <div class="cont">
            <h1><?php echo htmlspecialchars($product['productname']); ?></h1>
            <img src="admin/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['productname']); ?>">
        </div>
        <div class="cont">
            <p><?php echo htmlspecialchars($product['description']); ?></p>
            <p>Original Price: Rs <?php echo htmlspecialchars($product['original_price']); ?></p>
            <p>Discounted Price: Rs <?php echo htmlspecialchars($product['price']); ?></p>
            <div class="btn-list">
            <form action="add_to_cart.php" method="POST" class="add-to-cart-form">
                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['product_id']); ?>">
                <label for="quantity" class="">Quantity:</label>
                <input type="number" name="quantity" id="quantity" value="1" min="1" required>
                <button type="submit" class="btn cart-btn">Add to Cart</button>
            </form>
            <form action="add_to_wishlist.php" method="POST" class="add-to-wishlist-form">
                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['product_id']); ?>">
                <button type="submit" class="btn wishlist-btn">Add to Wishlist</button>
            </form>
        </div>

            <p class="average-rating">Average Rating: <?php echo $average_rating; ?> / 5</p>

            </div>
            
        
        <?php if (isset($_SESSION['username'])) : ?>
            <form action="submit_rating.php" method="POST" class="rating-form">
                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                <label for="rating">Rate this product:</label>
                <select name="rating" id="rating">
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
                <button type="submit" class="btn">Submit Rating</button>
            </form>
        <?php else : ?>
            <p><a href="login.php">Log in</a> to rate this product.</p>
        <?php endif; ?>
    </div>

    <!-- Include any additional content or scripts as needed -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<?php $con->close(); ?>
