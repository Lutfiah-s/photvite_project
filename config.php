<?php
$host = getenv("MYSQLHOST") ?: 'localhost';
$user = getenv("MYSQLUSER") ?: 'root';
$password = getenv("MYSQLPASSWORD") ?: '';
$database = getenv("MYSQLDATABASE") ?: 'photvite';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("conn gagal: " . $conn->connect_error);
}
?>
