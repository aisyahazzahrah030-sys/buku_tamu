<?php
// Config database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'buku_tamu_diskominfo');

// Koneksi database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Set charset
$conn->set_charset("utf8mb4");

// Fungsi untuk membersihkan input
function clean_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $conn->real_escape_string($data);
}

// Fungsi untuk upload file
function upload_file($file, $target_dir, $max_size = 5242880) {
    if (!isset($file['tmp_name']) || $file['tmp_name'] == '') {
        return null;
    }
    
    $target_file = $target_dir . basename($file["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Validasi file
    $check = getimagesize($file["tmp_name"]);
    if ($check === false) {
        throw new Exception("File yang diupload bukan gambar.");
    }
    
    // Cek ukuran file (max 5MB)
    if ($file["size"] > $max_size) {
        throw new Exception("Ukuran file terlalu besar. Maksimal 5MB.");
    }
    
    // Cek format
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        throw new Exception("Hanya file JPG, JPEG, PNG & GIF yang diperbolehkan.");
    }
    
    // Generate nama file unik
    $new_filename = uniqid() . '.' . $imageFileType;
    $target_file = $target_dir . $new_filename;
    
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return $new_filename;
    } else {
        throw new Exception("Gagal mengupload file.");
    }
}
?>