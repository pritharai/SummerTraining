<?php
include('header.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Sustainable Fashion</title>
    <link rel="stylesheet" href="contact.css">
    <link rel="stylesheet" href="style.css">
    <style>
        
    </style>
</head>

<body>
    <div class="login-nav"></div>

    <div class="contact-container">
        

        <?php if (isset($_GET['status']) && $_GET['status'] == 'success') : ?>
            <div class="contact-header">
            <h1>Thank You</h1>
            <p>We love to hear from our users!</p>
        </div>
            <div class="status-message">Thank you for contacting us. We will get back to you shortly.</div>
        <?php endif; 

        '<div class="contact-header">
            <h1>Contact Us</h1>
            <p>We would love to hear from you!</p>
        </div>
        <div class="contact-section">
            <h2>Get in Touch</h2>
            <form action="contact_process.php" method="POST">
                <label for="name">Name:</label>
                <input type="text" id="name" name="username" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="5" required></textarea>

                <button type="submit" class="btn custom-btn">Send Message</button>
            </form>
        </div>'
        ?>
    </div>

    <?php
    include('footer.php');
    ?>

</body>

</html>
