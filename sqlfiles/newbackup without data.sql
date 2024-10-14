CREATE TABLE `brands` ( 
  `brand_id` INT AUTO_INCREMENT NOT NULL,
  `brand_name` VARCHAR(100) NOT NULL,
  `category_id` INT NOT NULL,
  CONSTRAINT `PRIMARY` PRIMARY KEY (`brand_id`)
);
CREATE TABLE `categories` ( 
  `category_id` INT AUTO_INCREMENT NOT NULL,
  `category_name` VARCHAR(100) NOT NULL,
  CONSTRAINT `PRIMARY` PRIMARY KEY (`category_id`)
);
CREATE TABLE `products` ( 
  `product_id` INT AUTO_INCREMENT NOT NULL,
  `category_id` INT NULL,
  `brand_id` INT NULL,
  `product_name` VARCHAR(255) NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `flavor` VARCHAR(100) NULL,
  `color` VARCHAR(50) NULL,
  `puffs` INT NULL,
  `description` TEXT NULL,
  `img_dir` VARCHAR(255) NULL,
  CONSTRAINT `PRIMARY` PRIMARY KEY (`product_id`)
);
CREATE TABLE `users` ( 
  `id` INT AUTO_INCREMENT NOT NULL,
  `last_name` VARCHAR(50) NOT NULL,
  `first_name` VARCHAR(50) NOT NULL,
  `middle_name` VARCHAR(50) NULL,
  `birthday` DATE NOT NULL,
  `identification_url` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `contact_number` VARCHAR(15) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `home_address` VARCHAR(255) NULL,
  `region` VARCHAR(100) NOT NULL,
  `province` VARCHAR(100) NOT NULL,
  `city` VARCHAR(100) NOT NULL,
  `municipality` VARCHAR(100) NULL,
  `barangay` VARCHAR(100) NOT NULL,
  `zipcode` VARCHAR(10) NULL,
  `is_admin` TINYINT NULL DEFAULT 0 ,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ,
  `is_verified` TINYINT NULL DEFAULT 0 ,
  CONSTRAINT `PRIMARY` PRIMARY KEY (`id`),
  CONSTRAINT `email` UNIQUE (`email`)
);


ALTER TABLE `products` ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE `products` ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`brand_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

INSERT INTO `users` (`id`, `last_name`, `first_name`, `middle_name`, `birthday`, `identification_url`, `email`, `contact_number`, `password`, `home_address`, `region`, `province`, `city`, `municipality`, `barangay`, `zipcode`, `is_admin`, `created_at`, `is_verified`) VALUES
(1, 'Admin', 'Admin', NULL, '2000-01-01', 'cstmr-id/default_id.png', 'admin@admin.com', '0000000000', '$2y$10$UDr4x1tKcXNiYJldbvLgSuXE9jLstKG5py.64xn7Q6S8yKjGqsBuO', '123 Admin Street', 'Main St', 'Admin Province', 'Admin City', 'Admin Municipality', 'Admin Barangay', '12345', 1, '2024-09-19 10:26:26', 0);

INSERT INTO `brands` (`brand_id`, `brand_name`, `category_id`) VALUES
(3, 'FLAVA', 3),
(4, 'TEST BRAND', 2),
(5, 'TEST JUICE BRANCD', 1),
(6, 'TEST BRAND VAPES', 2);

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Juice'),
(2, 'Vapes'),
(3, 'Disposables'),
(4, 'NEW CATEGORY');

CREATE TABLE `faqs` (
  `faq_id` int(11) NOT NULL,
  `question` mediumtext NOT NULL,
  `answer` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`faq_id`, `question`, `answer`) VALUES
(1, 'What are the different types of vaping devices available?', 'Vaping devices come in various types such as cigalikes, vape pens, pod mods, box mods, and mechanical mods.'),
(2, 'Is vaping safer than smoking traditional cigarettes?', 'While vaping is considered to be less harmful than smoking traditional cigarettes, it is not completely risk-free. Vaping still involves inhaling aerosols containing nicotine and other chemicals.'),
(3, 'How do I choose the right nicotine strength for my e-liquid?', 'Nicotine strength selection depends on factors like your smoking history and vaping habits. Beginners typically start with lower nicotine strengths (3-6mg/ml), while heavy smokers may opt for higher concentrations (12-18mg/ml).'),
(4, 'What are the main ingredients in e-liquids?', 'E-liquids typically contain propylene glycol (PG), vegetable glycerin (VG), nicotine, and flavorings. Some may also contain distilled water or other additives.'),
(5, 'How often should I change the coil in my vaping device?', 'Coil lifespan varies depending on usage, e-liquid composition, and maintenance. On average, coils should be replaced every 1-4 weeks to maintain optimal performance and flavor.'),
(6, 'Are there any regulations regarding vaping products?', 'Regulations for vaping products vary by region. It\'s important to stay informed about local laws regarding sales, advertising, and usage of vaping devices and e-liquids.');
