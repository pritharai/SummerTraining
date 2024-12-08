<?php
include('header.php');

if (!isset($_SESSION['username'])) {
    header('location.href:logout.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell Your Clothes - Thrift Clothes Online</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="thrift.css">
    <link rel="stylesheet" href="rent.css">
</head>

<body>
    <div class="login-nav"></div>

    <section id="sell" class="sell">

        <h2>Sell Your Clothes</h2>
        <div class="form-container">


            <form id="sell-form" action="process_sell.php" method="POST" enctype="multipart/form-data">
                <label for="item-name">Item Name:</label>
                <input type="text" id="item-name" name="item_name" required>

                <label for="description">Description:</label>
                <textarea id="description" name="description" required></textarea>

                <label for="price">Price ($):</label>
                <input type="number" id="price" name="price" required>

                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" required>

                <label for="image">Upload Image:</label>
                <input type="file" id="image" name="image" required>

                <button type="submit" class="btn custom-btn btn-custom" style="width: 200px;">Submit</button>


            </form>
        </div>

    </section>

    <?php
    include('footer.php');
    ?>
</body>

</html>