<?php
// Reset password admin
echo "<h1>🔐 Reset Password Admin</h1>";

// Connection parameters
$host = 'localhost';
$user = 'root';
$pass = '';
$db_name = 'buku_tamu_diskominfo';

// Connect to database
$conn = new mysqli($host, $user, $pass, $db_name);

if ($conn->connect_error) {
    echo "<p style='color:red;'>❌ Connection failed: " . $conn->connect_error . "</p>";
    exit;
}

// Create/Update admin password
$username = 'admin';
$password = 'admin123';
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$nama_lengkap = 'Administrator Diskominfo';

echo "<h2>🔧 Admin User Details:</h2>";
echo "<p><strong>Username:</strong> $username</p>";
echo "<p><strong>Password:</strong> $password</p>";
echo "<p><strong>Hashed Password:</strong> $hashed_password</p>";

// Check if admin exists
$sql = "SELECT id, username FROM admin WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Update existing admin
    $admin_id = $result->fetch_assoc()['id'];
    
    $update_sql = "UPDATE admin SET password = ?, nama_lengkap = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssi", $hashed_password, $nama_lengkap, $admin_id);
    
    if ($update_stmt->execute()) {
        echo "<p style='color:green;'>✅ Password admin berhasil diperbarui!</p>";
    } else {
        echo "<p style='color:red;'>❌ Gagal update password: " . $update_stmt->error . "</p>";
    }
    
    $update_stmt->close();
} else {
    // Insert new admin
    $insert_sql = "INSERT INTO admin (username, password, nama_lengkap) VALUES (?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("sss", $username, $hashed_password, $nama_lengkap);
    
    if ($insert_stmt->execute()) {
        echo "<p style='color:green;'>✅ Admin baru berhasil dibuat!</p>";
    } else {
        echo "<p style='color:red;'>❌ Gagal membuat admin: " . $insert_stmt->error . "</p>";
    }
    
    $insert_stmt->close();
}

$stmt->close();

// Test password verification
echo "<h2>🧪 Test Password Verification:</h2>";
$test_password = 'admin123';
if (password_verify($test_password, $hashed_password)) {
    echo "<p style='color:green;'>✅ Password verification: SUCCESS</p>";
} else {
    echo "<p style='color:red;'>❌ Password verification: FAILED</p>";
}

// Show all admin users
echo "<h2>👥 Current Admin Users:</h2>";
$admin_list = $conn->query("SELECT id, username, nama_lengkap, created_at FROM admin ORDER BY id");

if ($admin_list->num_rows > 0) {
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Username</th><th>Nama Lengkap</th><th>Created</th></tr>";
    
    while ($row = $admin_list->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
        echo "<td>" . htmlspecialchars($row['nama_lengkap']) . "</td>";
        echo "<td>" . $row['created_at'] . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
} else {
    echo "<p style='color:orange;'>⚠️ Tidak ada admin users ditemukan</p>";
}

$conn->close();

echo "<h2>🚀 Test Login Sekarang:</h2>";
echo "<p>Silakan login dengan:</p>";
echo "<ul>";
echo "<li><strong>Username:</strong> admin</li>";
echo "<li><strong>Password:</strong> admin123</li>";
echo "</ul>";
echo "<p><a href='admin/login.php'>🔗 Login Admin</a></p>";
echo "<p><a href='index.php'>🔗 Form Buku Tamu</a></p>";
?>