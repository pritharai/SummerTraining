<?php
// session_start();
// if (!isset($_SESSION["username"])) {
//     header("Location: login.php");
//     exit();
// }

include('header.php');
include("connect.php");

// Fetch logged-in user's details
// $username = $_SESSION["username"];
$fetched_username = $mail = '';

if ($username) {
    $sql = "SELECT username, email FROM user WHERE username = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($fetched_username, $email);
    $stmt->fetch();
    $stmt->close();
}

// Fetch data from inventory table for rent
$sql = "SELECT * FROM inventory WHERE category = 'rent'";
$result = $con->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clothing Rental</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="rent.css">
    <link rel="stylesheet" href="style.css">
    <style>
         .heading {
            text-align: center;
            margin-top: 0px;
            height: 400px;
            background-image: url(./assets/rentland.avif);
            background-size: cover;
            background-position: center;
            background-repeat: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #FFC1B4;
            font-size: 50px;
        }
        .custom-btn {
            margin-left: 35%;
        }
        .rent {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 360px;
        }
    </style>
</head>
<body>
    <div class="login-nav"></div>
    <div class="heading">
        <h1>Rent the Best Clothes</h1>
        <p>Find the perfect outfit for any occasion.</p>
        <button class="btn custom-btn fs-4" style="width: 18em; margin-right: 30%;">
            <a href="collection.php" style="color: aliceblue;">Browse Collection</a>
        </button>
    </div>

    <section id="collection">
        <h2>Our Collection</h2>
        <div class="product-container">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="rent card">';
                    echo '<img src="' . htmlspecialchars('admin/' . $row["image"]) . '" alt="Image">';
                    echo '<div class="product-desc">';
                    echo '<h4>' . htmlspecialchars($row["productname"]) . '</h4>';
                    echo '<p>$' . htmlspecialchars($row["price"]) . ' per day</p>';
                    echo '<a href="booking.php?product_id=' . urlencode($row["product_id"]) . '" class="btn btn-custom" style="width:120px">Rent Now</a>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "No products found.";
            }
            ?>
        </div>
    </section>

    <section id="contact">
        <h2>Contact Us</h2>
        <div class="rent-form">
            <form action="process_contact.php" method="POST">
                <label for="message">Message:</label>
                <textarea id="message" name="message" required></textarea>

                <button type="submit" class="btn" style="width:240px">Send Message</button>
            </form>
        </div>
    </section>

    <?php include('footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$con->close();
?>
