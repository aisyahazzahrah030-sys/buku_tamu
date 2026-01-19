<?php
// Test file untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Debug Test</h1>";

// Test path include
echo "<h2>Testing include paths:</h2>";
echo "Current working directory: " . getcwd() . "<br>";
echo "File location: " . __FILE__ . "<br>";
echo "Directory: " . __DIR__ . "<br>";

// Test include database
echo "<h2>Testing database include:</h2>";
try {
    require_once '../config/database.php';
    echo "✅ Database config loaded successfully<br>";
} catch (Exception $e) {
    echo "❌ Error loading database: " . $e->getMessage() . "<br>";
}

// Test session
echo "<h2>Testing session:</h2>";
session_start();
echo "✅ Session started<br>";

// Test file existence
echo "<h2>Testing file existence:</h2>";
$db_file = '../config/database.php';
echo "Database file exists: " . (file_exists($db_file) ? '✅ Yes' : '❌ No') . "<br>";
echo "Full path: " . realpath($db_file) . "<br>";

echo "<h2>Directory listing:</h2>";
$parent_dir = dirname(__DIR__);
echo "Parent directory: $parent_dir<br>";
if (is_dir($parent_dir)) {
    $files = scandir($parent_dir);
    echo "Contents: <br>";
    foreach ($files as $file) {
        echo "- $file<br>";
    }
}
?>