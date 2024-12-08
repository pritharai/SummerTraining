<?php
include("header.php");
include('connect.php');

// Check if user is already subscribed
// $isSubscribed = false;


$sql = "SELECT * FROM inventory WHERE category='shop'";
$result = $con->query($sql);

$con->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
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

        input[type="email"] {
            width: 400px;
            height: 40px;
        }
    </style>

</head>

<body>
    <div id="home">
        <div class="des">
            <h1>Modiste</h1>
            <p>Your Fashion, Your Way</p>
        </div>
        <div class="collection">
            <h3>SUMMERTIME</h3>
            <div class="btns">
                <button type="button" class="btn btn-outline-danger">MEN's</button>
                <button type="button" class="btn btn-outline-danger">WOMEN's</button>
            </div>
        </div>
    </div>
    <div class="best-selling">
        <h1>Best-Sellers</h1>
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
    <div class="container2">
        <h1 class="text">Why Choose Us?</h1>
        <div class="functionality">
            <div class="func">
                <img src="./assets/rent.png" alt="">
                <p>Rent</p>
            </div>
            <div class="func">
                <img src="./assets/sell.png" alt="">
                <p>Sell</p>
            </div>
            <div class="func">
                <img src="./assets/thrift.png" alt="">
                <p style="margin-left:-15px">Thrift</p>
            </div>
            <div class="func">
                <img src="./assets/custom.png" alt="">
                <p>Custom Tailored</p>
            </div>
            <div class="func">
                <img src="./assets/brand.png" alt="">
                <p>Luxury Products</p>
            </div>
        </div>
        <h3 class="text">Styling With Love</h3>
    </div>
    <div class="container3">
        <div class="banner">
            <a href="thrift.php">
                <img src="./assets/thrifted5.jpg" alt="" class="banner-img">

            </a>
            <div class="on-img-text">
                <h2>Thrift Show</h2>
                <h3>40% off</h3>
            </div>
        </div>
        <div class="banner">
            <a href="rent.php">
                <img src="./assets/lehnga2.jpg" alt="" class="banner-img">


            </a>
            <div class="on-img-text">
                <h2>Rental Lehngas</h2>
                <h3>20% off</h3>
            </div>
        </div>
        <div class="banner">
            <img src="./assets/customed2.webp" class="banner-img">
            <div class="on-img-text">
                <h2>FOR YOU</h2>
                <h3>Custom Tailored</h3>
            </div>
        </div>
    </div>
    <div class="container4">
        <h1>Modiste redefines fashion with curated styles to own, affordable rentals, sustainable thrifting, and bespoke tailoring for a personalized touch.</h1>
    </div>
    <div class="container5">
        <div class="banner1">
            <img src="./assets/banner1.jpg" alt="">
            <button class="btn"></button>
            <button class="btn"></button>
        </div>
        <div class="banner2">
            <img src="./assets/banner2.jpg" alt="">
            <button class="btn"></button>
            <button class="btn"></button>
        </div>
    </div>
    <div class="best-selling">
        <h1>This Week's Top Picks</h1>
        <div class="product-container">
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="card">';
                    echo '<img src="admin/' . $row["image"] . '" alt="sorry">';

                    // Form for adding to cart
                    echo '<div class="icon-bar">';
                    echo '<form action="add_to_cart.php" method="POST" class="add-to-cart-form">';
                    echo '<input type="hidden" name="product_id" value="' . $row["product_id"] . '">';
                    echo '<input type="hidden" name="quantity" value="1">'; // Default quantity to 1
                    echo '<a href="javascript:void(0);" onclick="this.closest(\'form\').submit();"><i class="bi bi-cart fs-2 card_icon1"></i></a>';

                    echo '<i class="bi bi-balloon-heart fs-2 card_icon2"></i>';
                    echo '</div>';

                    echo '<div class="product-desc">';
                    echo '<h4>' . $row["productname"] . '</h4>';
                    echo '</form>';

                    echo '<p><del style="color:grey">' . $row["original_price"] . '$</del>&nbsp;' . $row["price"] . '$</p>';
                    echo '<span class="review"><i class="bi bi-star"></i><i class="bi bi-star"></i><i class="bi bi-star"></i><i class="bi bi-star"></i><i class="bi bi-star"></i></span>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "No products found.";
            }
            ?>
        </div>
    </div>
    <div class="email-container">
        <div class="mail">
            
            <h2>Subscribe to get 20% discount</h2>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
            <button type="button" class="btn" onclick="subscribe()">Subscribe</button>
        </div>
    </div>

    <div class="top-arrow">
        <a href="#home"><i class="bi bi-arrow-up icol"></i></a>
    </div>

    <?php
    include("footer.php");
    ?>
 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>
