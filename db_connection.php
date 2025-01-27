<?php
function getConnection() {
    $host = 'localhost';
    $dbname = 'food_fusion';
    $username = 'root';
    $password = '';
    $charset = 'utf8mb4';

    try {
        // Create DSN
        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
        
        // Configure PDO options
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        // Create PDO instance
        $pdo = new PDO($dsn, $username, $password, $options);
        
        return $pdo;
    } catch(PDOException $e) {
        // Log the error
        error_log("Database Connection Error: " . $e->getMessage());
        
        // In development, you might want to see the error
        if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1' || $_SERVER['REMOTE_ADDR'] === '::1') {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
        
        // In production, show a generic error
        throw new PDOException("Connection failed: Database error occurred");
    }
}
?>