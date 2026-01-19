<?php
session_start();
require_once __DIR__ . '/../config/database.php';

// Hapus semua session
session_destroy();

// Redirect ke halaman login
header('Location: login.php');
exit;
?>