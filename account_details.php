<?php
// include('connect.php');
include('header.php');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("location: logout.php");
    exit();
}

// Get current user details
$username = $_SESSION['username'];
$sql = "SELECT * FROM user WHERE username = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("User not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Details</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
}

.container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
form{
    margin-left: 11%;
}
h2 {
    text-align: center;
    margin-bottom: 20px;
}

.btn {
    width: 100%;
    padding: 10px;
    margin-top: 20px;
    background-color: #FE6F77;
}
.btn:hover{
    background-color: #FE3C47;
}

    </style>
</head>
<body>
     <div class="login-nav"></div>
    <div class="container col mt-5 ">
        <h2>Account Details</h2>
        <form action="account.php" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep current password">
            </div>
            <div class="mb-3">
                <label for="contact" class="form-label">Contact</label>
                <input type="text" class="form-control" id="contact" name="contact" value="<?php echo htmlspecialchars($user['contact']); ?>" required>
            </div>
            <button type="submit" class="btn btn-custom">Update Details</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $password = $_POST['password'];

    if (!empty($password)) {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $sql = "UPDATE user SET email = ?, contact = ?, password = ? WHERE username = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('ssss', $mail, $contact, $password_hash, $nausernameme);
    } else {
        $sql = "UPDATE user SET email = ?, contact = ? WHERE username = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('sss', $email, $contact, $username);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Account details updated successfully');</script>";
    } else {
        echo "<script>alert('Error updating account details');</script>";
    }
}
?>

<?php $con->close(); ?>
