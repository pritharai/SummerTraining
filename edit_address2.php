<?php
include('header.php');
include('connect.php');
// session_start();

if (isset($_GET['username'])) {
    $username = $_GET['username'];

    // Fetch record from database
    $sql = "SELECT * FROM user_address WHERE address_id='$address_id'";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
       
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $address = $_POST['address'];
        $pin = $_POST['pin'];
        // $original_price = $_POST['original_price'];

       
             
                // Update image field in database
                $sql = "UPDATE post SET 
                        fname='$fname', 
                        lname='$lname', 
                        email='$email', 
                        -- pdesc='$pdesc', 
                        contact='$contact', 
                        address='$address',
                        pin='$pin'
                        WHERE address_id='$address_id'";
          
            // No new image uploaded, retain the existing image path
            $sql = "UPDATE user_address (username, email, contact, address, pin) VALUES ('$username', '$email', '$contact', '$address', '$pin')"; 

        if ($con->query($sql) === TRUE) {
            echo '<script>alert("Product updated successfully.");
                window.location.href = "index.php";</script>';
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    }
} else {
    // header("Location: index.php");
    exit();
}

$conn->close();
?>


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Recipe</title>
        <link rel="stylesheet" href="style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <style>
            /* body {
                padding: 20px;
            } */
        </style>
    </head>
    <body>
        <div class="login-nav"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h1 class="mt-4">Edit Address</h1>
                
                <form action="address.php" method="POST" enctype="multipart/form-data">
                    <!-- <div class="form-group">
                        <label for="product_id">Id :</label>
                        <input type="text" id="product_id" name="address_id" value="" class="form-control" readonly>
                    </div> -->

                    <div class="form-group">
                        <label for="pname">Name:</label>
                        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($row['username']); ?>" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="name">Address:</label>
                        <input type="address" id="address" name="address" value="<?php echo htmlspecialchars($row['address']); ?>" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="pdesc">Phone no:</label>
                        <input type="phone" id="phone" name="phone" value="<?php echo htmlspecialchars($row['phone']); ?>" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="original_price">Email:</label>
                        <input type="mail" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" class="form-control" required>
                    </div>


                    <div class="form-group">
                        <label for="pin">Pin:</label>
                        <input type="number" id="pin" name="pin" class="form-control" style="width : 500px ; height:50px;">
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>