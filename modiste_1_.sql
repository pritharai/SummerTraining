-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 08, 2024 at 02:13 PM
-- Server version: 8.0.39
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `modiste(1)`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('admin', 'admin'),
('admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `productname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `totalCost` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `productname` (`productname`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `username`, `productname`, `email`, `start_date`, `end_date`, `totalCost`, `created_at`) VALUES
(1, 'Pritha', 'Lace Long Sleeve Wedding Dress ', 'pritharai873@gmail.com', '2024-12-07', '2024-12-10', 15200.00, '2024-12-06 23:39:33'),
(2, 'Aditya Narayan Rai', 'Lace Long Sleeve Wedding Dress ', 'adityanarayanrai651@gmail.com', '2024-12-07', '2024-12-14', 16400.00, '2024-12-07 03:06:11');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;
CREATE TABLE IF NOT EXISTS `carts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `productname` varchar(200) NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `image` blob NOT NULL,
  `price` bigint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

DROP TABLE IF EXISTS `contact_us`;
CREATE TABLE IF NOT EXISTS `contact_us` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `username`, `email`, `message`, `submitted_at`) VALUES
(1, 'Pritha', 'pritharai873@gmail.com', '7789hhhhhhhhhhhhhhhhhh', '2024-12-07 17:36:39');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
CREATE TABLE IF NOT EXISTS `inventory` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `productname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` varchar(200) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `original_price` decimal(10,2) NOT NULL,
  `stock` int NOT NULL,
  `category` varchar(50) NOT NULL,
  PRIMARY KEY (`product_id`),
  UNIQUE KEY `productname` (`productname`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`product_id`, `productname`, `description`, `image`, `price`, `original_price`, `stock`, `category`) VALUES
(2, 'Lace Long Sleeve Wedding Dress ', 'Fanciest Elegant Lace Long Sleeve Wedding Dress for Women India ', 'uploads/653930ab72dd6323dc48e4b7-fanciest-women-39-s-lace-wedding.jpg', 300.00, 14000.00, 18, 'rent'),
(3, 'Women\'s Anarkali Floral Printed Kurta Pent Set with Dupatta Anarkali Kurta for Women', 'Women\'s Anarkali Floral Printed Kurta Pent Set with Dupatta Anarkali Kurta for Women | Kurta Set | Ethnic Set | Dupatta Set', 'uploads/anarkali.jpg', 899.00, 3999.00, 50, 'shop'),
(5, 'Cashmere Sweater for Women', 'Black bodycon dress', 'uploads/82b95d421e9b_670x.webp', 4500.00, 16700.00, 10, 'Shop'),
(6, 'Kalki Bridal Lehnga', 'Kalki Bridal Red Lehnga with Silver Works. Semi-Stitched', 'uploads/bridal.avif', 7500.00, 70000.00, 35, 'Rent');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_subscribers`
--

DROP TABLE IF EXISTS `newsletter_subscribers`;
CREATE TABLE IF NOT EXISTS `newsletter_subscribers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `subscribed_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `product_id` int NOT NULL,
  `productname` varchar(255) NOT NULL,
  `address_id` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `image` blob,
  `order_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('Pending','Processing','Shipped','Delivered','Cancelled') DEFAULT 'Pending',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

DROP TABLE IF EXISTS `ratings`;
CREATE TABLE IF NOT EXISTS `ratings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `user_mail` varchar(200) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `rating` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `user_mail` (`user_mail`)
) ;

-- --------------------------------------------------------

--
-- Table structure for table `rent_contact_form`
--

DROP TABLE IF EXISTS `rent_contact_form`;
CREATE TABLE IF NOT EXISTS `rent_contact_form` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `message` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rent_contact_form`
--

INSERT INTO `rent_contact_form` (`id`, `username`, `email`, `message`, `created_at`) VALUES
(1, 'Pritha', '', 'hello', '2024-12-06 15:33:59'),
(2, 'Aditya Narayan Rai', '', 'hlo! testing this website', '2024-12-07 03:15:25');

-- --------------------------------------------------------

--
-- Table structure for table `shop_product`
--

DROP TABLE IF EXISTS `shop_product`;
CREATE TABLE IF NOT EXISTS `shop_product` (
  `pid` int NOT NULL AUTO_INCREMENT,
  `pname` text NOT NULL,
  `image` blob NOT NULL,
  `pdesc` text NOT NULL,
  `original_price` int NOT NULL,
  `discounted_price` int NOT NULL,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `pid` (`pid`),
  KEY `pid_2` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `shop_product`
--

INSERT INTO `shop_product` (`pid`, `pname`, `image`, `pdesc`, `original_price`, `discounted_price`) VALUES
(1, 'Lehnga', 0x75706c6f6164732f6c65686e6761332e6a7067, 'Red Bridal Lehnga', 70000, 54000),
(2, 'Party Black Dress', 0x75706c6f6164732f426c61636b2070617274792064726573732e6a7067, 'Black party dress for women', 780, 640);

-- --------------------------------------------------------

--
-- Table structure for table `thrift_items`
--

DROP TABLE IF EXISTS `thrift_items`;
CREATE TABLE IF NOT EXISTS `thrift_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `image` blob NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `thrift_items`
--

INSERT INTO `thrift_items` (`id`, `item_name`, `description`, `price`, `phone`, `image`, `created_at`, `updated_at`) VALUES
(5, 'Vintage Denim Jacket', 'Vintage 1970&#039;s 2 pocket Levis Denim Jacket. Good condition', 1500.00, '9041307588', 0x65316237303537613330303531393962626331363036663437383636643431662e6a7067, '2024-12-06 17:50:01', '2024-12-06 17:50:01'),
(7, 'Levis Denim Skirt', 'Levis Denim Skirt - 26W UK 6 Blue Cotton', 3400.00, '9041307588', 0x456c655f44616973795f6d69785f32362e31312e32343134335f66313333333639362d653833372d346233632d623733302d6563303036363065393237645f363730782e77656270, '2024-12-07 07:45:46', '2024-12-07 07:45:46'),
(8, '', 'Dolce &amp; Gabbana Jumper - Small Beige Angora Blend', 9400.00, '9041307588', 0x3832623935643432316539625f363730782e77656270, '2024-12-07 07:50:51', '2024-12-07 07:50:51'),
(10, 'H&amp;M Conscious Exclusive Rare Green Dress', 'H&amp;M Conscious Exclusive Rare Green Dress. Size- XS. Brand new with tag', 4999.00, '9041307588', 0x48264d2e77656270, '2024-12-07 08:08:47', '2024-12-07 08:08:47'),
(12, 'Forever 21 Maroon Dress', 'Forever 21 Maroon Dress Size-L. Good Condition Gently used ', 999.00, '9041307588', 0x666f726576657232312d636f6e74656d706f726172795f64726573735f313633363930393133305f66326362626539365f70726f67726573736976652e6a7067, '2024-12-07 08:34:07', '2024-12-07 08:34:07');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` text NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `email`, `contact`) VALUES
('Aditya Narayan Rai', 'aditya0717', 'adityanarayanrai651@gmail.com', '8968688938'),
('Pritha', '1234', 'pritharai873@gmail.com', '09041307588');

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

DROP TABLE IF EXISTS `user_address`;
CREATE TABLE IF NOT EXISTS `user_address` (
  `address_id` int NOT NULL AUTO_INCREMENT,
  `user_email` varchar(200) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `contact` varchar(15) DEFAULT NULL,
  `address` text,
  `pin` varchar(10) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`address_id`),
  KEY `user_email` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_address`
--

INSERT INTO `user_address` (`address_id`, `user_email`, `username`, `contact`, `address`, `pin`, `country`, `created_at`) VALUES
(1, 'pritharai873@gmail.com', 'Pritha Rai', '8966557850', 'House no. 201 G.K. Vihar, Manekwal Road, Near Gillz Dairy\r\nNear Jain Mandir, Dhandhra Road', '141116', 'India', '2024-12-07 16:22:09'),
(3, 'pritharai873@gmail.com', 'Pritha', '8968688938', 'House no. 201 G.K. Vihar, Manekwal, Dhandhra Road', '141116', 'India', '2024-12-07 17:05:52');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

DROP TABLE IF EXISTS `wishlist`;
CREATE TABLE IF NOT EXISTS `wishlist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_email` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `product_id` int NOT NULL,
  `productname` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `original_price` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_email` (`user_email`,`product_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_email`, `username`, `product_id`, `productname`, `description`, `image`, `original_price`, `price`) VALUES
(3, 'adityanarayanrai651@gmail.com', 'Aditya Narayan Rai', 2, 'Lace Long Sleeve Wedding Dress ', 'Fanciest Elegant Lace Long Sleeve Wedding Dress for Women India ', 'uploads/653930ab72dd6323dc48e4b7-fanciest-women-39-s-lace-wedding.jpg', 14000.00, 300.00);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`email`) REFERENCES `user` (`email`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`productname`) REFERENCES `inventory` (`productname`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `inventory` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `inventory` (`product_id`),
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`user_mail`) REFERENCES `user` (`email`);

--
-- Constraints for table `user_address`
--
ALTER TABLE `user_address`
  ADD CONSTRAINT `user_address_ibfk_1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `inventory` (`product_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
