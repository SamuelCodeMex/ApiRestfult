<?php
$host = 'localhost';
$db_name = 'bweohwzv_b2';
$username = 'bweohwzv_b2';
$password = 'kgJTQhm7xj6zGzqCEgm9';
define('API_KEY', 'yy&785gRt454Dyt9Kpryngh145uyet');

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $exception) {
    echo "Connection error: " . $exception->getMessage();
}
?>
