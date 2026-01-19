<?php
echo "<h1>Test PHP</h1>";
echo "<p>PHP Version: " . PHP_VERSION . "</p>";
echo "<p>Current Directory: " . __DIR__ . "</p>";
echo "<p>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p>Request URI: " . $_SERVER['REQUEST_URI'] . "</p>";
echo "<p><a href='login.php'>Test Login Link</a></p>";
?>