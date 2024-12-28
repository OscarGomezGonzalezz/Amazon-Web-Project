USE amazonDB;

CREATE TABLE `Articles` (
 `article_id` int(11) NOT NULL AUTO_INCREMENT,
 `name` varchar(255) NOT NULL,
 `price` float NOT NULL,
 `quantity` int(11) NOT NULL,
 `image_url` varchar(255) NOT NULL,
 PRIMARY KEY (`article_id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO Articles (name, price, quantity, image_url) VALUES
('Küchenmaschine', 49.99, 100, './images/articles/Küchenmaschine.jpeg'),
('Fire TV Stick 4K', 59.99, 150, './images/articles/fire_tv_stick.jpeg'),
('Kindle Paperwhite', 129.99, 80, './images/articles/kindle_paperwhite.jpeg'),
('Ring Video Doorbell', 99.99, 120, './images/articles/ring_video_doorbell.jpeg'),
('Instant Pot Duo 7-in-1', 89.99, 75, './images/articles/instant_pot.jpeg'),
('Echo Show 5', 84.99, 90, './images/articles/echo_show_5.jpeg'),
('Fire HD 10 Tablet', 149.99, 60, './images/articles/fire_hd_10.jpeg'),
('AmazonBasics AA Batteries', 12.99, 200, './images/articles/amazon_basics_batteries.jpeg'),
('Chalkboard Labels (Set of 48)', 10.99, 300, './images/articles/chalkboard_labels.jpeg'),
('Wireless Charging Pad', 29.99, 110, './images/articles/wireless_charger.jpeg'),
('Anker PowerCore Portable Charger', 39.99, 150, './images/articles/powercore.jpeg'),
('Smart Wi-Fi Plug', 24.99, 130, './images/articles/smart_plug.jpeg');

CREATE TABLE `Users` (
 `user_id` int(11) NOT NULL AUTO_INCREMENT,
 `email` varchar(255) NOT NULL,
 `password_hash` char(128) NOT NULL,
 `last_activity` timestamp(1) NOT NULL DEFAULT current_timestamp(1) ON UPDATE current_timestamp(1),
 `is_online` tinyint(1) DEFAULT 0,
 `must_change_password` tinyint(4) DEFAULT 1,
 PRIMARY KEY (`user_id`),
 UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `LoginLogs` (
 `log_id` int(11) NOT NULL AUTO_INCREMENT,
 `user_id` int(11) NOT NULL,
 `login_time` timestamp NOT NULL DEFAULT current_timestamp(),
 `screen_resolution` varchar(20) DEFAULT NULL,
 `os` varchar(50) DEFAULT NULL,
 PRIMARY KEY (`log_id`),
 KEY `user_id` (`user_id`),
 CONSTRAINT `loginlogs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `Cart` (
 `cart_id` int(11) NOT NULL AUTO_INCREMENT,
 `user_id` int(11) NOT NULL,
 `article_id` int(11) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
 `quantity` int(11) NOT NULL DEFAULT 0,
 PRIMARY KEY (`cart_id`),
 KEY `article_id` (`article_id`),
 KEY `user_id` (`user_id`),
 CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`article_id`),
 CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `Orders` (
 `order_id` int(11) NOT NULL AUTO_INCREMENT,
 `user_id` int(11) NOT NULL,
 `first_name` varchar(50) NOT NULL,
 `last_name` varchar(50) NOT NULL,
 `email` varchar(100) NOT NULL,
 `address` text NOT NULL,
 `shipping_method` varchar(50) NOT NULL,
 `total_price` decimal(10,2) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
 PRIMARY KEY (`order_id`),
 KEY `user_id` (`user_id`),
 CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `OrderItems` (
 `order_item_id` int(11) NOT NULL AUTO_INCREMENT,
 `order_id` int(11) NOT NULL,
 `article_name` varchar(255) NOT NULL,
 `quantity` int(11) NOT NULL,
 `price` decimal(10,2) NOT NULL,
 `image_url` varchar(255) NOT NULL,
 PRIMARY KEY (`order_item_id`),
 KEY `order_id` (`order_id`),
 CONSTRAINT `orderitems_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `Orders` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `PromoCodes` (
 `code_id` int(11) NOT NULL AUTO_INCREMENT,
 `code_name` varchar(50) NOT NULL,
 `discount_amount` int(11) NOT NULL,
 `is_active` int(11) NOT NULL DEFAULT 0,
 PRIMARY KEY (`code_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


insert into PromoCodes(code_name, discount_amount) values('10BLACKFRIDAY', 10);