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
CREATE TABLE `messages` ( 
  `id` INT AUTO_INCREMENT NOT NULL,
  `sender_id` INT NOT NULL,
  `receiver_id` INT NOT NULL,
  `content` TEXT NOT NULL,
  `timestamp` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ,
  `is_read` TINYINT NULL DEFAULT 0 ,
  CONSTRAINT `PRIMARY` PRIMARY KEY (`id`)
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