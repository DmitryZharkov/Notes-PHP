<?php

try {
    $conn = new mysqli("localhost", "root", "645321");
} catch (\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
    }
?>