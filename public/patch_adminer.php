<?php
$file = 'adminer.php';
$content = file_get_contents($file);

$collisions = ['lang'];

foreach ($collisions as $func) {
    // definition
    $content = preg_replace('/function\s+'.$func.'\s*\(/i', 'function adminer_'.$func.'(', $content);
    // calls
    $content = preg_replace('/(?<!->|::|\$|function\s)\b'.$func.'\s*\(/i', 'adminer_'.$func.'(', $content);
}

file_put_contents($file, $content);
echo "Successfully patched collisions: " . implode(', ', $collisions);
?>
