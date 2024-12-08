<?php
// search.php
include('header.php');
include('connect.php'); // Database connection file

if (isset($_GET['query'])) {
    $search_query = $_GET['query'];
    $con = new mysqli("localhost", "root", "root", "modiste(1)");

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM inventory WHERE productname LIKE ? OR description LIKE ?";
    $stmt = $con->prepare($sql);
    $like_query = "%" . $search_query . "%";
    $stmt->bind_param("ss", $like_query, $like_query);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .card a {
            text-decoration: none;
            color: darkgray;
        }

        .card a:hover {
            color: gray;
        }
    </style>
</head>

<body>
    <div class="login-nav"></div>
    <h1 class="heading">Search Results for "<?php echo htmlspecialchars($search_query); ?>"</h1>
    <div class="search-results">
        <div class="product-container">
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="card">';
                    echo '<a href="shop_product_details.php?product_id=' . $row["product_id"] . '">';
                    echo '<img src="admin/' . $row["image"] . '" alt="sorry">';
                    echo '</a>';

                    echo '<div class="icon-bar">';
                    // Form for adding to wishlist
                    echo '<form action="add_to_wishlist.php" method="POST" class="add-to-wishlist-form">';
                    echo '<input type="hidden" name="product_id" value="' . $row["product_id"] . '">';
                    echo '<a href="javascript:void(0);" onclick="this.closest(\'form\').submit();"><i class="bi bi-balloon-heart fs-2 card_icon2"></i></a>';
                    echo '</form>';

                    // Form for adding to cart
                    echo '<form action="add_to_cart.php" method="POST" class="add-to-cart-form">';
                    echo '<input type="hidden" name="product_id" value="' . $row["product_id"] . '">';
                    echo '<input type="hidden" name="quantity" value="1">'; // Default quantity to 1
                    echo '<a href="javascript:void(0);" onclick="this.closest(\'form\').submit();"><i class="bi bi-cart fs-2 card_icon1"></i></a>';
                    echo '</div>';

                    echo '<div class="product-desc">';
                    echo '<a href="product_details.php?product_id=' . $row["product_id"] . '">';
                    echo '<h4>' . $row["productname"] . '</h4>';
                    echo '</a>';
                    echo '</form>';

                    echo '<p><del style="color:grey">Rs.' . $row["original_price"] . '</del>&nbsp;Rs.' . $row["price"] . '</p>';
                    // Display availability status
                    if ($row["stock"] > 10) {
                        echo '<p style="color:green;">Available</p>';
                    } elseif ($row["stock"] > 0 && $row["stock"] <= 10) {
                        echo '<p style="color:orange;">A few left</p>';
                    } else {
                        echo '<p style="color:red;">Sold out</p>';
                    }

                    // if($category =)

                    // Display Rent it button if the category is 'rent'
                    if ($row["category"] === 'Rent') {
                    echo '<a href="booking.php?name=' . urlencode($row["productname"]) . '" class="btn custom-btn" style="width:120px">Rent Now</a>';
                    }

                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "No products found.";
            }
            ?>
        </div>
    </div>
    <?php include('footer.php'); ?>
</body>

</html>
<?php
$stmt->close();
$con->close();
?>