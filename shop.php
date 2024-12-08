<?php
include('header.php');
include('connection.php');

$whereClauses = ["category = 'shop'"];

if (isset($_GET['min_price'])) {
    $min_price = intval($_GET['min_price']);
    $whereClauses[] = "price >= $min_price";
}

if (isset($_GET['max_price'])) {
    $max_price = intval($_GET['max_price']);
    $whereClauses[] = "price <= $max_price";
}

$whereSql = implode(' AND ', $whereClauses);
$sql = "SELECT * FROM inventory WHERE $whereSql";
$result = $con->query($sql);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shop</title>
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

        .section {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin: 50px 0;
        }

        .section-item {
            position: relative;
            width: 20%;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .section-item img {
            width: 100%;
            height: 300px;
            display: block;
            transition: transform 0.3s ease;
        }

        .section-item p {
            position: absolute;
            bottom: 20px;
            left: 20px;
            margin: 0;
            padding: 10px 20px;
            background-color: rgba(0, 0, 0, 0.5);
            color: #fff;
            font-size: 24px;
            font-weight: bold;
            border-radius: 5px;
            text-transform: uppercase;
        }

        .section-item a {
            text-decoration: none;
            color: inherit;
        }

        .section-item:hover {
            transform: scale(1.05);
        }

        .section-item:hover img {
            transform: scale(1.1);
        }

        .card a {
            text-decoration: none;
            color: darkgray;
        }

        .card a:hover {
            color: gray;
        }

        .card h4 {
            margin: 0;
        }
    </style>

</head>

<body>
    <div class="login-nav"></div>
    <h1 class="heading">Shop your latest trends</h1>
    <div class="shop_page">
        <div class="filter">
            <button class="btn custom-btn mx-5 mt-5" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                Filters
            </button>

            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Filters</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <form method="GET" action="shop.php">
                        <div class="mb-3">
                            <label for="min_price" class="form-label">Min Price</label>
                            <input type="number" class="form-control" id="min_price" name="min_price" value="<?php echo isset($_GET['min_price']) ? htmlspecialchars($_GET['min_price']) : ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="max_price" class="form-label">Max Price</label>
                            <input type="number" class="form-control" id="max_price" name="max_price" value="<?php echo isset($_GET['max_price']) ? htmlspecialchars($_GET['max_price']) : ''; ?>">
                        </div>
                        <button type="submit" class="btn btn-custom">Apply Filters</button>
                        <a href="shop.php" class="btn btn-custom">Clear Filters</a>
                    </form>
                </div>
            </div>
        </div>
        <div class="section">
            <div class="section-item">
                <a href="womens_shop.php">
                    <img src="./assets/women.jpg" alt="Women">
                    <p>Women</p>
                </a>
            </div>

            <div class="section-item">
                <a href="mens_shop.php">
                    <img src="./assets/men.avif" alt="Men">
                    <p>Men</p>
                </a>
            </div>
        </div>

        <div class="best-selling">
            <h1>Flaunt You</h1>
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
                    echo '<a href="shop_product_details.php?product_id=' . $row["product_id"] . '">';
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
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "No products found.";
            }
            ?>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <?php
    include('footer.php');
    ?>
</body>

</html>

<?php
$con->close();
?>
