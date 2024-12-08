DROP TABLE IF EXISTS Users;

CREATE TABLE `Users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password_hash` char(128) NOT NULL,
  `last_activity` timestamp(1) NOT NULL DEFAULT current_timestamp(1) ON UPDATE current_timestamp(1),
  `is_online` tinyint(1) DEFAULT 0,
  `must_change_password` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
