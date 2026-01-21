<?php
$c = file_get_contents('adminer.php');
foreach(['config', 'auth', 'lang', 'trans'] as $f) {
    if (preg_match('/function\s+'.$f.'\s*\(/i', $c)) {
        echo "Found collision: $f\n";
    }
}
