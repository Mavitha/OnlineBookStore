<?php
// Database configuration
$host = '127.0.0.1';
$dbname = 'bookstore_db';
$username = 'root'; // Change this if your database user is different
$password = 'M#vith#179';     // Change this if your database has a password

// Data Source Name
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

// PDO options for security and error handling
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // Create a new PDO instance
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    // Stop execution and show an error message if the connection fails
    die("Database connection failed: " . $e->getMessage());
}

echo "Connection done";
?>