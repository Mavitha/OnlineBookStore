<?php
// Include your database connection
require_once '../backend/php/connection.php';

// Generate the correct, secure hash for "123"
$correctHash = password_hash('123', PASSWORD_DEFAULT);

try {
    // Force the database to update the admin user with this exact hash
    $stmt = $pdo->prepare("UPDATE users SET password_hash = :hash WHERE username = 'admin'");
    $stmt->execute(['hash' => $correctHash]);
    
    echo "<h1>Success!</h1>";
    echo "<p>The admin password has been correctly hashed and updated to '123'.</p>";
    echo "<a href='login.php'>Click here to go login</a>";
    
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>