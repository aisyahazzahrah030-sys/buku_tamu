<?php
// Simple database connection test
echo "<h1>Database Connection Test</h1>";

// Connection parameters
$host = 'localhost';
$user = 'root';
$pass = '';
$db_name = 'buku_tamu_diskominfo';

echo "Testing connection to MySQL server...<br>";

// Test connection to MySQL server first
$conn = new mysqli($host, $user, $pass);

if ($conn->connect_error) {
    echo "❌ Connection failed: " . $conn->connect_error . "<br>";
    echo "<h2>Possible solutions:</h2>";
    echo "<ul>";
    echo "<li>Check if XAMPP MySQL is running</li>";
    echo "<li>Verify MySQL username/password (default: root/empty)</li>";
    echo "<li>Check if MySQL port 3306 is available</li>";
    echo "</ul>";
    exit;
}

echo "✅ Connected to MySQL server successfully<br>";

// Check if database exists
echo "Checking if database '$db_name' exists...<br>";
$result = $conn->query("SHOW DATABASES LIKE '$db_name'");
if ($result->num_rows == 0) {
    echo "❌ Database '$db_name' does not exist<br>";
    echo "<h2>How to create database:</h2>";
    echo "<ol>";
    echo "<li>Open phpMyAdmin: <a href='http://localhost/phpmyadmin' target='_blank'>http://localhost/phpmyadmin</a></li>";
    echo "<li>Click 'New' in left sidebar</li>";
    echo "<li>Enter database name: <strong>buku_tamu_diskominfo</strong></li>";
    echo "<li>Click 'Create'</li>";
    echo "<li>Then import the SQL file from: C:/xampp2/htdocs/buku_tamu/database.sql</li>";
    echo "</ol>";
} else {
    echo "✅ Database '$db_name' exists<br>";
    
    // Test connection to specific database
    $conn->select_db($db_name);
    echo "✅ Selected database '$db_name' successfully<br>";
    
    // Check if tables exist
    echo "<br>Checking tables...<br>";
    $tables = ['admin', 'buku_tamu'];
    foreach ($tables as $table) {
        $result = $conn->query("SHOW TABLES LIKE '$table'");
        if ($result->num_rows > 0) {
            echo "✅ Table '$table' exists<br>";
        } else {
            echo "❌ Table '$table' missing<br>";
        }
    }
}

$conn->close();
?>