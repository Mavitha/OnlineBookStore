-- Drop the database if it exists so we can start fresh with the new column
DROP DATABASE IF EXISTS bookstore_db;

-- Create the database
CREATE DATABASE bookstore_db;
USE bookstore_db;

-- 1. Create Users Table (Admin Authentication)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'customer') DEFAULT 'customer'
);

-- 2. Create Books Table (Updated with trending_score)
CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    cover_image VARCHAR(255) DEFAULT 'default_cover.jpg',
    trending_score INT DEFAULT 0 -- The higher the number, the more trending it is!
);

-- 3. Create Orders Table (Polished for Delivery & Billing)
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    book_id INT NOT NULL,
    customer_name VARCHAR(255) NOT NULL,
    customer_email VARCHAR(255) NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    payment_status ENUM('Pending', 'Completed', 'Failed') DEFAULT 'Pending',
    delivery_status ENUM('Processing', 'Shipped', 'Delivered', 'Cancelled') DEFAULT 'Processing',
    tracking_number VARCHAR(100) DEFAULT NULL,
    delivery_service_provider VARCHAR(100) DEFAULT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
);

-- ==========================================
-- INSERT DUMMY DATA
-- ==========================================

-- Insert Admin
INSERT INTO users (username, password_hash, role) 
VALUES ('admin', '$2y$10$e.w2Kj4Kx.B7H8H.R9h/2e.0.1.2.3.4.5.6.7.8.9.0.1.2.3.4', 'admin');

-- Insert Books (Now with trending_score data)
INSERT INTO books (title, author, category, price, cover_image, trending_score) VALUES 
('The Pragmatic Programmer', 'David Thomas', 'Educational', 45.00, 'pragmatic.jpg', 150),
('Dune', 'Frank Herbert', 'Fiction', 20.50, 'dune.jpg', 500),
('Clean Code', 'Robert C. Martin', 'Educational', 50.00, 'cleancode.jpg', 320);

-- Insert Dummy Orders
INSERT INTO orders 
(book_id, customer_name, customer_email, total_price, payment_method, payment_status, delivery_status, tracking_number, delivery_service_provider) 
VALUES 
(2, 'Jane Doe', 'jane@example.com', 20.50, 'Credit Card', 'Completed', 'Shipped', 'TRK987654321', 'FedEx'),
(3, 'John Smith', 'john@example.com', 50.00, 'Bank Transfer', 'Pending', 'Processing', NULL, NULL);