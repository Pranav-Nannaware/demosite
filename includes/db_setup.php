<?php
/**
 * Database Setup Script
 * 
 * This script creates all necessary tables for the CMRIT website.
 * Run this script once to set up the database.
 */

require_once 'config.php';

// Array to store SQL queries
$queries = [];

// Create social_links table
$queries[] = "CREATE TABLE IF NOT EXISTS `social_links` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(50) NOT NULL,
    `url` varchar(255) NOT NULL,
    `icon_class` varchar(50) NOT NULL,
    `display_order` int(11) NOT NULL DEFAULT 0,
    `is_active` tinyint(1) NOT NULL DEFAULT 1,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// Create menu_items table
$queries[] = "CREATE TABLE IF NOT EXISTS `menu_items` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(50) NOT NULL,
    `url` varchar(255) NOT NULL,
    `page_slug` varchar(50) DEFAULT NULL,
    `parent_id` int(11) NOT NULL DEFAULT 0,
    `display_order` int(11) NOT NULL DEFAULT 0,
    `is_active` tinyint(1) NOT NULL DEFAULT 1,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// Create site_content table
$queries[] = "CREATE TABLE IF NOT EXISTS `site_content` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `content_key` varchar(50) NOT NULL,
    `title` varchar(100) DEFAULT NULL,
    `content` text NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `content_key` (`content_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// Create quick_links table
$queries[] = "CREATE TABLE IF NOT EXISTS `quick_links` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(50) NOT NULL,
    `url` varchar(255) NOT NULL,
    `section` varchar(50) NOT NULL,
    `display_order` int(11) NOT NULL DEFAULT 0,
    `is_active` tinyint(1) NOT NULL DEFAULT 1,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// Create programs table
$queries[] = "CREATE TABLE IF NOT EXISTS `programs` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(100) NOT NULL,
    `slug` varchar(100) NOT NULL,
    `short_description` text DEFAULT NULL,
    `description` text NOT NULL,
    `icon_class` varchar(50) DEFAULT NULL,
    `image` varchar(255) DEFAULT NULL,
    `display_order` int(11) NOT NULL DEFAULT 0,
    `is_active` tinyint(1) NOT NULL DEFAULT 1,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// Create facilities table
$queries[] = "CREATE TABLE IF NOT EXISTS `facilities` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(100) NOT NULL,
    `description` text NOT NULL,
    `image` varchar(255) DEFAULT NULL,
    `display_order` int(11) NOT NULL DEFAULT 0,
    `is_active` tinyint(1) NOT NULL DEFAULT 1,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// Create achievements table
$queries[] = "CREATE TABLE IF NOT EXISTS `achievements` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(100) NOT NULL,
    `description` text NOT NULL,
    `icon_class` varchar(50) DEFAULT NULL,
    `display_order` int(11) NOT NULL DEFAULT 0,
    `is_active` tinyint(1) NOT NULL DEFAULT 1,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// Create testimonials table
$queries[] = "CREATE TABLE IF NOT EXISTS `testimonials` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(100) NOT NULL,
    `position` varchar(100) DEFAULT NULL,
    `content` text NOT NULL,
    `image` varchar(255) DEFAULT NULL,
    `display_order` int(11) NOT NULL DEFAULT 0,
    `is_active` tinyint(1) NOT NULL DEFAULT 1,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// Create sliders table
$queries[] = "CREATE TABLE IF NOT EXISTS `sliders` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(100) NOT NULL,
    `subtitle` text DEFAULT NULL,
    `button_text` varchar(50) DEFAULT NULL,
    `button_url` varchar(255) DEFAULT NULL,
    `image` varchar(255) NOT NULL,
    `display_order` int(11) NOT NULL DEFAULT 0,
    `is_active` tinyint(1) NOT NULL DEFAULT 1,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// Create announcements table
$queries[] = "CREATE TABLE IF NOT EXISTS `announcements` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `content` text NOT NULL,
    `url` varchar(255) DEFAULT NULL,
    `start_date` date DEFAULT NULL,
    `end_date` date DEFAULT NULL,
    `is_active` tinyint(1) NOT NULL DEFAULT 1,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// Create users table for admin panel
$queries[] = "CREATE TABLE IF NOT EXISTS `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(50) NOT NULL,
    `password` varchar(255) NOT NULL,
    `email` varchar(100) NOT NULL,
    `name` varchar(100) NOT NULL,
    `role` enum('admin','editor') NOT NULL DEFAULT 'editor',
    `is_active` tinyint(1) NOT NULL DEFAULT 1,
    `last_login` datetime DEFAULT NULL,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `username` (`username`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// Create contact_messages table
$queries[] = "CREATE TABLE IF NOT EXISTS `contact_messages` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(100) NOT NULL,
    `email` varchar(100) NOT NULL,
    `subject` varchar(255) NOT NULL,
    `message` text NOT NULL,
    `is_read` tinyint(1) NOT NULL DEFAULT 0,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// Execute all queries
$success = true;
$error_messages = [];

foreach ($queries as $query) {
    try {
        $db->exec($query);
    } catch (PDOException $e) {
        $success = false;
        $error_messages[] = $e->getMessage();
    }
}

// Insert default admin user
if ($success) {
    try {
        // Check if admin user already exists
        $stmt = $db->query("SELECT COUNT(*) FROM users WHERE username = 'admin'");
        $admin_exists = (int) $stmt->fetchColumn();
        
        if (!$admin_exists) {
            // Create default admin user with password 'admin123'
            $password_hash = password_hash('admin123', PASSWORD_DEFAULT);
            $db->exec("INSERT INTO users (username, password, email, name, role) VALUES 
                ('admin', '$password_hash', 'admin@cmrit.edu.in', 'Administrator', 'admin')");
        }
    } catch (PDOException $e) {
        $success = false;
        $error_messages[] = $e->getMessage();
    }
}

// Output result
if ($success) {
    echo "Database setup completed successfully!";
    echo "<br>Default admin credentials: username: admin, password: admin123";
    echo "<br><strong>Important:</strong> Please change the default password immediately after first login.";
} else {
    echo "Error setting up database:<br>";
    echo implode("<br>", $error_messages);
}
?> 