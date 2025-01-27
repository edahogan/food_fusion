<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    require_once 'db_connection.php';
    
    echo "✅ Successfully included db_connection.php\n\n";
    
    // Test database parameters before connection
    $host = 'localhost';
    $dbname = 'food_fusion';
    $username = 'root';
    $password = '';
    
    echo "Attempting connection with:\n";
    echo "Host: $host\n";
    echo "Database: $dbname\n";
    echo "Username: $username\n";
    echo "Password: [hidden]\n\n";

    // Test the connection
    $conn = getConnection();
    
    // Try a simple query
    $testQuery = "SELECT 1";
    $result = $conn->query($testQuery);
    
    if ($result) {
        echo "✅ Database connection successful!\n\n";
        
        // Get database info
        echo "Database Information:\n";
        echo "Server Info: " . $conn->getAttribute(PDO::ATTR_SERVER_VERSION) . "\n";
        echo "Connection Status: " . ($conn->getAttribute(PDO::ATTR_CONNECTION_STATUS) ?? "Connected") . "\n";
        echo "Server Info: " . $conn->getAttribute(PDO::ATTR_SERVER_INFO) . "\n";
        
        // Test if we can access the Users table
        $userQuery = "SELECT COUNT(*) as count FROM Users";
        $userResult = $conn->query($userQuery);
        $userCount = $userResult->fetch(PDO::FETCH_ASSOC)['count'];
        echo "\nNumber of users in database: " . $userCount . "\n";
        
    } else {
        echo "❌ Connection test query failed\n";
    }
    
} catch (PDOException $e) {
    echo "❌ Database Connection Error:\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "Code: " . $e->getCode() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n\n";
    
    // Check if MySQL is running
    $mysqlRunning = false;
    if (function_exists('exec')) {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            exec('net start mysql', $output, $returnVal);
            $mysqlRunning = $returnVal === 0;
        } else {
            exec('pgrep mysqld', $output, $returnVal);
            $mysqlRunning = !empty($output);
        }
        echo "MySQL Service Status: " . ($mysqlRunning ? "Running" : "Not Running") . "\n";
    }
    
    // Check if database exists
    try {
        $tmpConn = new PDO("mysql:host=$host", $username, $password);
        $stmt = $tmpConn->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dbname'");
        $dbExists = $stmt->fetch() !== false;
        echo "Database '$dbname' exists: " . ($dbExists ? "Yes" : "No") . "\n";
    } catch (PDOException $e2) {
        echo "Could not check if database exists: " . $e2->getMessage() . "\n";
    }
} catch (Exception $e) {
    echo "❌ General Error:\n";
    echo $e->getMessage() . "\n";
}

// Check PHP version and extensions
echo "\nSystem Information:\n";
echo "PHP Version: " . phpversion() . "\n";
echo "PDO Drivers: " . implode(", ", PDO::getAvailableDrivers()) . "\n";
echo "PDO MySQL Extension: " . (extension_loaded('pdo_mysql') ? "Loaded" : "Not Loaded") . "\n";
?> 