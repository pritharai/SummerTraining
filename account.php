<?php
include("header.php");

if (!isset($_SESSION["username"])) {
  // Redirect to the sign-in page if not logged in
  header("Location: logout.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
    <link rel="stylesheet" href="style.css" type="css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
   
    <style>

    .heading{
      text-align: center;
      margin-top: -30px;
      height: 300px;
      background-image: url(./assets/acc_header.avif);
      background-size: cover;
      background-position: center;
      background-repeat: none;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #FEAE6F;
      font-size: 50px;
    }
      .tab{
    display: flex;
    justify-content: center;
    flex-direction: row;
    flex-wrap: wrap;
    align-items: center;
    align-content: center;
    gap:30px;
    /* border: 2px solid black; */
}
.list_acc{
    display: flex;
    flex-direction: column;
    flex-wrap: nowrap;
    align-items: center;
    justify-content: center;
    align-content: center;
    gap: 10px;
    border: 1px solid #d9d9d9;
    border-radius: 25px;
    height: 280px;
    width: 500px;
    padding: 20px;
    margin: 5px;
    font-size: 20px;
}
.accicon{
    font-size: 30px;
}
.btn{
  border-style: none;
  height: 50px;
    width: 200px;
    /* border-style: none; */
    background-color: #FE6F77;
    color: aliceblue;
    font-size: 22px;
    cursor: pointer;
    padding-block: 0px;
}
.btn:hover{
  background-color: #FE3C47;
}
.welcome{
  margin-top: 20px;
  color:#FEAE6F;
  text-align: center;
}

    </style>

</head>
<body>
  <div class="login-nav"></div>
  <div class="account-page">
        <p><h1 class="heading">My Account</h1></p>
        
         <h1 class="welcome">Hello! <?php echo htmlspecialchars($_SESSION["username"]); ?>.</h1> 
        <div class="tab">
          <div class="list_acc">
            <i class="bi bi-box2-heart accicon"></i>
            <h1>My Orders</h1>
            <h3>Track orders and buy again</h3>
            <button class="btn" onclick="window.location.href='previous_orders.php'">My Orders</button>
          </div>
          <div class="list_acc">
            <i class="bi bi-box2-heart accicon"></i>
            <h1>My Details</h1>
            <h3>Update your Shipping Details</h3>
            <button class="btn" onclick="window.location.href='address.php'">Address Details</button>
          </div>
          <div class="list_acc">
            <i class="bi bi-box2-heart accicon"></i>
            <h1>Transactions & Refunds</h1>
            <h3>Track transactions and refunds</h3>
            <button class="btn">Bills</button>
          </div>
          <div class="list_acc">
            <i class="bi bi-box2-heart accicon"></i>
            <h1>Account Details</h1>
            <h3>Update Account details</h3>
            <button class="btn" onclick="window.location.href='account_details.php'">Account Details</button>
          </div>
        </div>
  </div>
    
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
   
</body>
<?php
include('footer.php');
?>
</html>

