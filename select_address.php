<?php
include('header.php');

if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION["email"];
$con = new mysqli("localhost", "root", "root", "modiste(1)");

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Fetch all addresses for the logged-in user
$address_sql = "SELECT * FROM user_address WHERE user_email = ?";
$address_stmt = $con->prepare($address_sql);
$address_stmt->bind_param("s", $email);
$address_stmt->execute();
$address_result = $address_stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Address</title>
    <link rel="stylesheet" href="address.css">
    <link rel="stylesheet" href="style.css">
    <style>
         body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    /* display: flex; */
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

form {
    background: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    padding: 20px 30px;
    width: 800px;
    margin: 100px auto;
}

form label {
    display: block;
    font-weight: bold;
    margin-bottom: 0px;
    color: #333;
}

form input[type="text"],
form textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 5px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

form textarea {
    resize: none;
    height: 100px;
}

form button {
    width: 100%;
    padding: 10px;
    /* background-color: #007bff; */
    border: none;
    border-radius: 4px;
    color: white;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

form button:focus {
    outline: none;
    box-shadow: 0 0 4px #007bff;
}
.btn{
    background-color: #FEAE6F;
}

    </style>
</head>
<body>
    <div class="login-nav"></div>
    <h1>Select a Shipping Address</h1>
    <form action="place_order.php" method="POST">
        <?php while ($row = $address_result->fetch_assoc()) { ?>
            <div class="address-card">
                <input type="radio" id="address-<?php echo $row['address_id']; ?>" name="address_id" value="<?php echo $row['address_id']; ?>" required>
                <label for="address-<?php echo $row['address_id']; ?>">
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($row['username']); ?></p>
                    <p><strong>Contact:</strong> <?php echo htmlspecialchars($row['contact']); ?></p>
                    <p><strong>Address:</strong> <?php echo htmlspecialchars($row['address']); ?></p>
                    <p><strong>Pin:</strong> <?php echo htmlspecialchars($row['pin']); ?></p>
                    <p><strong>Country:</strong> <?php echo htmlspecialchars($row['country']); ?></p>
                </label>
            </div>
        <?php } ?>
        <button type="submit" class="btn">Confirm Order</button>
    </form>
</body>
<?php
include('footer.php');
?>
</html>
<?php
$con->close();
?>
