<?php
include('header.php');
include('connect.php');

if (!isset($_SESSION["username"])) {
    // Redirect to the sign-in page if not logged in
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="admin.css" type="text/css">
</head>

<body>
    <div class="login-nav"></div>

    <div class="product-upload">
        <h1>Upload an Image</h1>
        <form method="post" enctype="multipart/form-data">
            <select name="category" id="category" required>
                <option value="Shop">Shop</option>
                <option value="Rent">Rent</option>
            </select>
            <input type="text" name="productname" placeholder="Enter product name" required>
            <input type="text" name="description" placeholder="Enter product description" required>
            <input type="number" name="original_price" placeholder="Enter original product cost" required>
            <input type="number" name="price" placeholder="Enter discounted product cost" required>
            <input type="number" name="stock" placeholder="Enter stock" required>
            Select image to upload:
            <input type="file" name="image" id="image" required>
            <button type="submit" value="Upload Image" name="submit">Upload Image</button>
        </form>
    </div>

</body>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image']) && isset($_POST['productname']) && isset($_POST['description']) && isset($_POST['original_price']) && isset($_POST['price']) && isset($_POST['stock']) && isset($_POST['category'])) {
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "<script>alert('File is not an image.');</script>";
            $uploadOk = 0;
        }

        if ($_FILES["image"]["size"] > 500000) {
            echo "<script>alert('Sorry, your file is too large.');</script>";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "<script>alert('Sorry, your file was not uploaded.');</script>";
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.<br>";
                echo "<br><img src='" . $target_file . "' alt='Uploaded Image' style='max-width: 500px;'><br>";

                $name = $_POST['productname'];
                $description = $_POST['description'];
                $original_price = $_POST['original_price'];
                $price = $_POST['price'];
                $stock = $_POST['stock'];
                $image = $target_file;
                $category = $_POST['category'];

                // Check if product name exists
                $check_sql = "SELECT COUNT(*) FROM inventory WHERE productname = ?";
                $check_stmt = $con->prepare($check_sql);
                $check_stmt->bind_param('s', $name);
                $check_stmt->execute();
                $check_stmt->bind_result($count);
                $check_stmt->fetch();
                $check_stmt->close();

                if ($count > 0) {
                    // Product name already exists
                    echo "<script>alert('Product name already exists. Please use a different name.');</script>";
                } else {
                    // Insert product into database
                    $sql = "INSERT INTO inventory (description, productname, original_price, price, stock, image, category) VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $con->prepare($sql);
                    $stmt->bind_param('ssddiss', $description, $name, $original_price, $price, $stock, $image, $category);

                    if ($stmt->execute()) {
                        echo "<script>alert('New product added successfully.');</script>";
                    } else {
                        echo "Error: " . $stmt->error . "<br>";
                    }
                }
            } else {
                echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
            }
        }
    }
}

$con->close();
?>


</html>
