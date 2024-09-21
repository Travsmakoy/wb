-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 21, 2024 at 06:34 AM
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
-- Database: `vapeshop1`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
CREATE TABLE IF NOT EXISTS `brands` (
  `brand_id` int NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(100) NOT NULL,
  `category_id` int NOT NULL,
  PRIMARY KEY (`brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_name`, `category_id`) VALUES
(3, 'FLAVA', 3),
(4, 'TEST BRAND', 2),
(5, 'TEST JUICE BRANCD', 1),
(6, 'TEST BRAND VAPES', 2);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Juice'),
(2, 'Vapes'),
(3, 'Disposables'),
(4, 'NEW CATEGORY');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `category_id` int DEFAULT NULL,
  `brand_id` int DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `flavor` varchar(100) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `puffs` int DEFAULT NULL,
  `description` text,
  `img_dir` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`product_id`),
  KEY `category_id` (`category_id`),
  KEY `brand_id` (`brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `brand_id`, `product_name`, `price`, `flavor`, `color`, `puffs`, `description`, `img_dir`) VALUES
(1, 3, 3, 'TEST', 1000.00, 'MINT', '0', 8000, '0', '../uploads/categ_dispo.png'),
(2, 2, 4, 'TEST', 50000.00, 'MINT', '0', 8000, '0', '../uploads/juice-hero-banner.png'),
(4, 2, 4, 'product test', 11111.00, 'TANG INA MO', '1234658', 8000, '123456', '../uploads/aerogin-logo.jpg'),
(5, 2, 4, 'UMARSKI', 123123.00, 'testflava', 'BLUE', 5000, 'ASDASDASDASDAS', '../uploads/image-sample.jpg'),
(6, 3, 3, 'TEST DISPO', 123123.00, 'MENTHOL', 'RED', 15000, 'THIS IS A TEST', '../uploads/image 611.png'),
(7, 2, 6, 'TEST PRODUCT VAPES', 7500.00, 'ULUKAPATTA', 'VIOLET', 10000, 'ASDJKHASD', '../uploads/17254434982342848810191bc72-60fa-7014-af4d-01bafdf2750a1720523119327_0.7467730466760583(1).jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `last_name` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `birthday` date NOT NULL,
  `identification_url` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `home_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `street` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `municipality` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `barangay` varchar(100) NOT NULL,
  `zipcode` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `last_name`, `first_name`, `middle_name`, `birthday`, `identification_url`, `email`, `contact_number`, `password`, `home_address`, `street`, `province`, `city`, `municipality`, `barangay`, `zipcode`, `is_admin`, `created_at`) VALUES
(1, 'Admin', 'Admin', NULL, '2000-01-01', 'cstmr-id/default_id.png', 'admin@admin.com', '0000000000', '$2y$10$UDr4x1tKcXNiYJldbvLgSuXE9jLstKG5py.64xn7Q6S8yKjGqsBuO', '123 Admin Street', 'Main St', 'Admin Province', 'Admin City', 'Admin Municipality', 'Admin Barangay', '12345', 1, '2024-09-19 10:26:26'),
(2, 'mark', 'casuco', NULL, '1997-05-05', 'cstmr-id/66ebfdedb4520-catalog-carousel-4.png', 'test@gmail.com', '1', '$2y$10$wQfgqruUXGQwu8CQR8UcoOhjUaksIs4aTCD.dbH1Lbt/Ciq92bQtS', '1', '03', '0377', '037701', NULL, '037701001', NULL, 0, '2024-09-19 10:33:17'),
(3, 'asdsad', 'asdasd', NULL, '1197-05-05', 'cstmr-id/66ebfe1c7bb24-banner_two.jpg', 'test1@gmail.com', '123', '$2y$10$vNsghGMhZOqEvcHmh0T0OeZAPrpIijrq.6FeunHSC9TD9FEhXMkLe', '123', '01', '0128', '012801', NULL, '012801001', NULL, 0, '2024-09-19 10:34:04'),
(4, 'Mark', 'casuco', NULL, '1997-05-05', 'cstmr-id/66ec25de44818-catalog-carousel-4.png', 'mark1@gmail.com', '09275462419', '$2y$10$2dnuXgE2lW/FRLemByswt.ErpFGg567mGxbSBqgrtQX/4MTc5QOV6', '1', '01', '0128', '012801', NULL, '012801001', NULL, 0, '2024-09-19 13:23:42'),
(5, 'Umar', 'Hassan', NULL, '1995-09-09', 'uploads/66ed76e7b7e12-blog-bg-one.png', 'test2@gmail.com', '09275462419', '$2y$10$iE1Mqk60moCJfyy/x0erf.HGN43W80mm6jXwmg7d6u51OWeiB2pFS', '123', '01', '0128', '012802', NULL, '012802003', NULL, 0, '2024-09-20 13:21:43'),
(6, 'asdsad', 'asdasd', NULL, '1993-05-05', 'cstmr-id/66ed78b69f96d-relx-logo.png', 'test5@gmail.com', '123456789', '$2y$10$lLRBjlyvtRIAt7/ruE6kveNJvuVJ6wlnuJy4zjA8LGbat6Ch.y.TG', '123', '11', '1182', '118207', NULL, '118207010', NULL, 0, '2024-09-20 13:29:26'),
(7, 'Umar', '2ndTry', NULL, '1996-12-12', 'cstmr-id/66ed79d1b8056-shft-logo.png', 'admin@example.com', '09275462419', '$2y$10$hmLfZn/uSe8NTBI.heGn0eujxoBaUBOC/xfPa7BCd/BOsXxFZosB.', '1', '11', '1124', '112402', NULL, '112402010', NULL, 0, '2024-09-20 13:34:09'),
(8, 'casuco', 'mjk', NULL, '1997-05-05', 'cstmr-id/66ee5571457ef-17262985936725786380191ef6a-1988-7f30-8850-bb80ec4004a4images.png', 'test10@gmail.com', '09275462419', '$2y$10$K7IMDNHmYfFIj7gjC0RyW.oFSS8YR7fZIlj5kPCcXJZLni9EbHz8q', '1', '01', '0128', '012801', NULL, '012801001', NULL, 0, '2024-09-21 05:11:13'),
(9, 'umarski', 'hassani', NULL, '1995-02-01', 'cstmr-id/66ee5c5ebfd8f-image 606.png', 'testumar@gmail.com', '09275462419', '$2y$10$z0aJNnGj5ZtN0otMlL58qefGgoIUK5FSGZTmLvyVGNCJGJ7z506Pa', '1', '05', '0517', '051707', NULL, '051707007', NULL, 0, '2024-09-21 05:40:46');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`brand_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
