<?php
// session_start();
include('connect.php'); // Your database connection
include('header.php');

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    // Redirect to the sign-in page if not logged in
    header("Location: login.php");
    exit();
}

// Fetch the logged-in username
$username = $_SESSION['username'];

// Get the user email from the 'user' table based on the logged-in username
$sql = "SELECT email FROM user WHERE username = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $user_email = $user['email']; // Store the user's email
} else {
    // If the email is not found, you can handle this case by redirecting or showing an error
    echo "User not found.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>wishlist</title>
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

        .margin-b {
            position: absolute;
            margin-bottom: -50px;
            right: 12%;
            bottom: 35%;
        }

        .margin-b2 {
            position: absolute;
            right: 10%;
            bottom: 35%;
        }

        .margin-b2 input[type="number"] {
            width: 150px;
        }
    </style>
</head>

<body>
    <div class="login-nav"></div>
    <h1 class="heading">Your favourites!</h1>

    <div class="product-container">
        <?php
        // Prepare a SQL query to fetch the wishlist items
        $stmt = $con->prepare("SELECT * FROM wishlist WHERE user_email = ?");
        $stmt->bind_param("s", $user_email); // Bind the user_email
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="wishlist-card">';
                echo '<form action="remove_from_wishlist.php" method="POST" class="remove-from-wishlist-form">';
                echo '<input type="hidden" name="product_id" value="' . $row["product_id"] . '">';
                echo '<a href="javascript:void(0);" onclick="this.closest(\'form\').submit();"><div class="remove-icon"><i class="bi bi-x-lg "></i></div></a>';
                echo '</form>';
                echo '<img src="admin/' . $row["image"] . '" alt="sorry" max-width="50px">';
                echo '<div class="product-desc">';
                echo '<h6>' . $row["productname"] . '</h6>';
                // echo '<p>' . $row["description"] . '</p>';
                echo '</div>';

                echo '<div class="margin-b2">';
                echo '<form action="add_to_cart.php" method="POST" class="add-to-cart-form">';
                echo '<input type="hidden" name="product_id" value="' . $row["product_id"] . '">';
                echo '<input type="number" name="quantity" value="1" min="1" class="mb-3"><br>';
                echo '<p><del style="color:grey"><span>&#8377;</span>' . $row["original_price"] . '</del>&nbsp;<span>&#8377;</span>' . $row["price"] . '</p>';
                echo '</div>';
                echo '<button type="submit" class="custom-btn btn margin-b" style="width:120px;">Add to Cart</button>';
                echo '</form>';
                echo '</div>';
            }
        } else {
            echo "No items in wishlist.";
        }

        $stmt->close();
        ?>
    </div>
    <?php
    include('footer.php');
    $con->close();
    ?>
</body>

</html>
