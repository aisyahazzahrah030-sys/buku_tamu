<?php
session_start();
require_once __DIR__ . '/../config/database.php';

echo "<h1>🔍 Debug Login Process</h1>";

// Test connection
$conn = connect_db();
if ($conn === null) {
    echo "<p style='color:red;'>❌ Database connection failed</p>";
    exit;
}
echo "<p style='color:green;'>✅ Database connected</p>";

// Test admin user lookup
$username = 'admin';
echo "<h2>👤 Checking Admin User: '$username'</h2>";

$stmt = $conn->prepare("SELECT id, username, password, nama_lengkap FROM admin WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $admin = $result->fetch_assoc();
    echo "<p style='color:green;'>✅ Admin user found</p>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Field</th><th>Value</th></tr>";
    echo "<tr><td>ID</td><td>" . $admin['id'] . "</td></tr>";
    echo "<tr><td>Username</td><td>" . htmlspecialchars($admin['username']) . "</td></tr>";
    echo "<tr><td>Nama Lengkap</td><td>" . htmlspecialchars($admin['nama_lengkap']) . "</td></tr>";
    echo "<tr><td>Password Hash</td><td>" . substr($admin['password'], 0, 20) . "...</td></tr>";
    echo "</table>";
    
    // Test password verification
    $test_passwords = ['admin123', 'admin', 'password', '123456'];
    
    echo "<h3>🧪 Testing Passwords:</h3>";
    foreach ($test_passwords as $pwd) {
        if (password_verify($pwd, $admin['password'])) {
            echo "<p style='color:green;'>✅ Password '$pwd' - CORRECT</p>";
        } else {
            echo "<p style='color:red;'>❌ Password '$pwd' - WRONG</p>";
        }
    }
    
} else {
    echo "<p style='color:red;'>❌ Admin user NOT found</p>";
    echo "<p>Users in database:</p>";
    
    $all_users = $conn->query("SELECT username, nama_lengkap FROM admin");
    if ($all_users->num_rows > 0) {
        echo "<ul>";
        while ($user = $all_users->fetch_assoc()) {
            echo "<li>" . htmlspecialchars($user['username']) . " - " . htmlspecialchars($user['nama_lengkap']) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p style='color:orange;'>⚠️ No users found in admin table</p>";
    }
}

$stmt->close();
$conn->close();

echo "<h2>🔧 Solutions:</h2>";
echo "<ol>";
echo "<li><a href='reset_admin.php'>🔄 Reset Admin Password</a></li>";
echo "<li><a href='setup.php'>📦 Run Full Setup</a></li>";
echo "<li><a href='admin/login.php'>🔐 Try Login Again</a></li>";
echo "</ol>";
?>