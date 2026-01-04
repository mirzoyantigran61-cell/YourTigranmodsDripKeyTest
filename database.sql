CREATE DATABASE IF NOT EXISTS `dripclient_db` DEFAULT CHARSET=utf8mb4;
USE `dripclient_db`;

-- Users table
CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `email` VARCHAR(255) UNIQUE NOT NULL,
  `username` VARCHAR(64) UNIQUE NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `is_admin` BOOLEAN DEFAULT FALSE
) ENGINE=InnoDB;

-- Keys table
CREATE TABLE `keys` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NULL,
  `user_id_external` VARCHAR(64) NOT NULL,
  `generated_key` VARCHAR(64) UNIQUE NOT NULL,
  `status` ENUM('active','used','banned') DEFAULT 'active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Insert admin
INSERT INTO `users` (`email`, `username`, `password_hash`, `is_admin`) VALUES
('mirzoyantigran61@gmail.com', 'YourTigranmods X Ankit', '$2y$10$FwL8ZJvX8kQm6t7E5fT9E.9zWc1rA2bC3dE4fG5hI6jK7lM8nO9pQ0r', 1);
