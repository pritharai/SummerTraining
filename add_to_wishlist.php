<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: logout.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $username = $_SESSION['username']; // Fetch username from session

    // Connect to the database
    $con = new mysqli("localhost", "root", "root", "modiste(1)");

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    // Fetch user email based on the username from the user table
    $sql = "SELECT email FROM user WHERE username = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_email = $row['email'];

        // Fetch product details from the inventory table
        $sql = "SELECT product_id, image, price, productname, description, original_price FROM inventory WHERE product_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $product_id = $row['product_id'];
            $image = $row['image'];
            $price = $row['price'];
            $productname = $row['productname'];
            $description = $row['description'];
            $original_price = $row['original_price'];

            // Check if the product is already in the wishlist for this user
            $sql = "SELECT product_id FROM wishlist WHERE user_email = ? AND product_id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("si", $user_email, $product_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<script>
                        alert('Product is already in your wishlist.');
                        window.location.href = 'wishlist.php';
                      </script>";
            } else {
                // Add the product to the wishlist
                $sql = "INSERT INTO wishlist (user_email, product_id, productname, description, image, original_price, price) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("sisssss", $user_email, $product_id, $productname, $description, $image, $original_price, $price);

                if ($stmt->execute()) {
                    echo "<script>
                            alert('Product added to wishlist successfully.');
                            window.location.href = 'wishlist.php';
                          </script>";
                } else {
                    echo "Error: " . $stmt->error;
                }
            }
        } else {
            echo "<script>
                    alert('Product not found.');
                    window.location.href = 'wishlist.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('User details not found.');
                window.location.href = 'logout.php';
              </script>";
    }

    // Close the statement and connection
    $stmt->close();
    $con->close();
}
?>
