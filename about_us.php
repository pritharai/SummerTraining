<?php
include('header.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Sustainable Fashion</title>
    <link rel="stylesheet" href="about.css">
    <link rel="stylesheet" href="style.css">
    <style>
       .heading {
            text-align: center;
            margin-top: 0px;
            height: 350px;
            background-image: url(./assets/thrifted6.avif);
            background-size: cover;
            background-position: center;
            background-repeat: none;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FEAE6F;
            font-size: 50px;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="login-nav"></div>

    <div class="heading">
        <div class="hero-content">
        <h1>About Us</h1>
            <p>Committed to Promoting Sustainable Fashion</p>
        </div>
    </div>
   
    <div class="about-container">
        

        <div class="about-section">
            <img src="./assets/about1.avif" alt="Our Mission">
            <div class="text">
                <h2>Our Mission</h2>
                <p>We believe in a world where fashion is sustainable and accessible to everyone. Our mission is to provide high-quality, pre-loved clothing and affordable rental options to help reduce the environmental impact of fashion. We strive to create a community of conscious consumers who value sustainability and ethical practices.</p>
            </div>
        </div>

        <div class="about-section">
            <img src="./assets/about2.avif" alt="Our Values">
            <div class="text">
                <h2>Our Values</h2>
                <p>At the core of our business are values that reflect our commitment to sustainability, community, and quality. We prioritize eco-friendly practices, support local communities, and ensure that all our products meet the highest standards. We believe in transparency and strive to make ethical choices in every aspect of our business.</p>
            </div>
        </div>

        <div class="about-section">
            <img src="./assets/about3.avif" alt="Buy, Rent, Thrift">
            <div class="text">
                <h2>Buy, Rent, Thrift</h2>
                <p>Our platform offers a variety of options for fashion enthusiasts. You can buy stylish second-hand clothes, rent outfits for special occasions, or thrift unique pieces at great prices. Additionally, we provide a platform for individuals to sell their pre-loved clothes, giving them a second life and reducing waste.</p>
            </div>
        </div>

        <div class="about-section">
            <img src="./assets/about4.avif" alt="Join Us">
            <div class="text">
                <h2>Join Us</h2>
                <p>We invite you to join our movement towards a more sustainable fashion industry. Explore our collections, rent your next outfit, thrift your wardrobe, or sell your pre-loved clothes with us. Together, we can make a difference and promote a more sustainable and ethical approach to fashion.</p>
            </div>
        </div>

       
    </div>
    <div class="cta-section">
            <h2>Get Started Today</h2>
            <p style="text-align:center">Join our community and start making a positive impact on the fashion industry.</p>
            <a href="shop.php">Shop Now</a>
        </div>

    <?php
    include('footer.php');
    ?>

</body>

</html>
