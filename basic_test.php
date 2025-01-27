<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $pdo = new PDO('mysql:host=localhost', 'root', '');
    echo "✅ Basic connection to MySQL successful!\n";
} catch (PDOException $e) {
    echo "❌ Basic connection failed: " . $e->getMessage() . "\n";
}
?> 