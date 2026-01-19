<?php
session_start();
require_once __DIR__ . '/../config/database.php';

// Cek login
if (!isset($_SESSION['admin_logged_in'])) {
    http_response_code(401);
    echo 'Unauthorized';
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // Use global connection from config
    global $conn;
    
    // Hapus foto jika ada
    $stmt = $conn->prepare("SELECT foto_tamu FROM buku_tamu WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if ($row['foto_tamu']) {
            $file_path = '../uploads/foto_tamu/' . $row['foto_tamu'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        
        // Hapus data dari database
        $delete_stmt = $conn->prepare("DELETE FROM buku_tamu WHERE id = ?");
        $delete_stmt->bind_param("i", $id);
        
        if ($delete_stmt->execute()) {
            echo 'success';
        } else {
            echo 'error';
        }
        
        $delete_stmt->close();
    } else {
        echo 'not_found';
    }
    
    $stmt->close();
} else {
    echo 'invalid_id';
}
?>