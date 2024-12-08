<?php
include('header.php');
include('connect.php');


$sql = "SELECT * FROM inventory WHERE category='rent'";
$result = $con->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Collection</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="rent.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .custom-btn{
            margin-left: 35%;
        }
    </style>
</head>

<body>
    <div class="login-nav"></div>

    <section id="collection" class="container mt-5">
        <h2>Our Collection</h2>
            <div class="product-container">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="card">';
                    echo '<img src="admin/' . $row["image"] . '" alt="sorry">';
                    echo '<div class="product-desc">';
                    echo '<h4>' . $row["productname"] . '</h4>';

                    echo '<p>Rs ' . $row["price"] . ' per day</p>';
                    echo '<a href="booking.php?product_id=' . urlencode($row["product_id"]) . '" class="btn custom-btn btn-custom" style="width:120px">Rent Now</a>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "No products found.";
            }
            ?>

            </div>
        
    </section>

    <?php
    include('footer.php');
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>

<?php
$con->close();
?>
