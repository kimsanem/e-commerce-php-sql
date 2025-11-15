<?php
# connect to the database
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'php_ecommerce';

$conn = new mysqli($host, $user, $password, $database);
//$conn = new mysqli('localhost', 'root', '', 'php_ecommerce');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>