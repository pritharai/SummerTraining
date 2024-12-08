<?php
include('header.php');
include('connect.php');

// Fetch data from thrift_items table
$sql = "SELECT * FROM thrift_items";
$result = $con->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thrift Clothes Online</title>
    <link rel="stylesheet" href="thrift.css">
    <style>
        .heading {
            text-align: center;
            margin-top: 0px;
            height: 350px;
            background-image: url(./assets/thrifted6.avif);
            background-size: cover;
            background-position: center;
            background-repeat: none;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FEAE6F;
            font-size: 50px;
        }
        .custom-btn{
            margin-left: 30%;
        }
    </style>
</head>
<body>
    <div class="login-nav"></div>

    <div class="heading">
        <div class="hero-content">
            <h1>Welcome to Thrift Clothes</h1>
            <p>Find unique and sustainable fashion pieces at amazing prices.</p>
        </div>
    </div>

    <section id="about" class="about">
        <h2>About Us</h2>
        <p>We are dedicated to offering the best thrifted clothing options. Our mission is to promote sustainable fashion by providing a platform where people can find and sell pre-loved clothes.</p>
    </section>

    <section id="shop" class="shop">
        <h2>Shop Our Collection</h2>
        <div class="product-container">
        <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="card">';
                    echo '<img src="uploads/' . $row["image"] . '" alt="sorry">';
                    echo '<div class="product-desc">';
                    echo '<h4>' . $row["item_name"] . '</h4>';

                    echo '<p> Rs.' . $row["price"] . '</p>';
                    echo '<a href="product_detail.php?id=' . urlencode($row["id"]) . '" class="btn custom-btn btn-custom" style="width:120px">Buy Now</a>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "No products found.";
            }
            ?>
        </div>
    </section>

    <section class="sell-cta">
        <h2>Have Clothes to Sell?</h2>
        <a href="sell.php" class="btn">Sell Your Clothes</a>
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
