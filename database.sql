-- CampusConnect: Lost & Found Portal
-- Database schema
-- Author: Karan Dhaodiyal

CREATE DATABASE IF NOT EXISTS lost_and_found_portal
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE lost_and_found_portal;

-- Items reported as found
CREATE TABLE IF NOT EXISTS items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(150) NOT NULL,
    category VARCHAR(50) NOT NULL DEFAULT 'Others',
    location VARCHAR(150) NOT NULL,
    description TEXT,
    item_image VARCHAR(255) NOT NULL,
    status ENUM('Available', 'Claimed') NOT NULL DEFAULT 'Available',
    date_found TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Claims submitted by students
CREATE TABLE IF NOT EXISTS claims (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_id INT NOT NULL,
    claimer_name VARCHAR(100) NOT NULL,
    student_id VARCHAR(50) NOT NULL,
    mobile VARCHAR(15) NOT NULL,
    claimer_id_card VARCHAR(255) NOT NULL,
    claimed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (item_id) REFERENCES items(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Admin accounts (passwords are bcrypt-hashed by the app on first login)
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

-- Default admin: username `admin`, password `admin123`
-- The app automatically upgrades this to a bcrypt hash on first login.
-- (change this password immediately after first login!)
INSERT INTO admin_users (username, password) VALUES
('admin', 'admin123');
