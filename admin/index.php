<?php
echo "<h1>Admin Dashboard</h1>";
echo "<p><a href='login.php'>🔐 Login Admin</a></p>";
echo "<p><a href='../index.php'>📝 Kembali ke Buku Tamu</a></p>";
echo "<h2>📁 File yang tersedia:</h2>";
$files = glob(__DIR__ . '/*.php');
foreach ($files as $file) {
    $filename = basename($file);
    echo "<p><a href='$filename'>$filename</a></p>";
}
?>