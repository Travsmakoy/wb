-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 19, 2024 at 11:26 AM
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `last_name`, `first_name`, `middle_name`, `birthday`, `identification_url`, `email`, `contact_number`, `password`, `home_address`, `street`, `province`, `city`, `municipality`, `barangay`, `zipcode`, `is_admin`, `created_at`) VALUES
(1, 'Admin', 'Admin', NULL, '2000-01-01', 'cstmr-id/default_id.png', 'admin@admin.com', '0000000000', '$2y$10$UDr4x1tKcXNiYJldbvLgSuXE9jLstKG5py.64xn7Q6S8yKjGqsBuO', '123 Admin Street', 'Main St', 'Admin Province', 'Admin City', 'Admin Municipality', 'Admin Barangay', '12345', 1, '2024-09-19 10:26:26'),
(2, 'mark', 'casuco', NULL, '1997-05-05', 'cstmr-id/66ebfdedb4520-catalog-carousel-4.png', 'test@gmail.com', '1', '$2y$10$wQfgqruUXGQwu8CQR8UcoOhjUaksIs4aTCD.dbH1Lbt/Ciq92bQtS', '1', '03', '0377', '037701', NULL, '037701001', NULL, 0, '2024-09-19 10:33:17'),
(3, 'asdsad', 'asdasd', NULL, '1197-05-05', 'cstmr-id/66ebfe1c7bb24-banner_two.jpg', 'test1@gmail.com', '123', '$2y$10$vNsghGMhZOqEvcHmh0T0OeZAPrpIijrq.6FeunHSC9TD9FEhXMkLe', '123', '01', '0128', '012801', NULL, '012801001', NULL, 0, '2024-09-19 10:34:04');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
