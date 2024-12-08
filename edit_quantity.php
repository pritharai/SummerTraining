<?php
// session_start();
include('header.php');

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION["username"];
$con = new mysqli("localhost", "root", "root", "modiste(1)");

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $new_quantity = $_POST['quantity'];

    $sql = "UPDATE carts SET quantity = '$new_quantity' WHERE username = '$username' AND product_id = '$product_id'";
    if ($con->query($sql) === TRUE) {
        echo "<script>alert('Quantity updated successfully'); window.location.href='orders.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    $con->close();
    exit();
}

$product_id = $_GET['product_id'];
$current_quantity = $_GET['quantity'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Quantity</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <h2>Edit Quantity</h2>
        <form action="edit_quantity.php" method="POST">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo $current_quantity; ?>" min="1">
            </div>
            <button type="submit" class="btn btn-primary">Update Quantity</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
<?php
$con->close();
?>
