<?php
$host = getenv("MYSQLHOST") ?: 'localhost';
$user = getenv("MYSQLUSER") ?: 'root';
$password = getenv("MYSQLPASSWORD") ?: '';
$database = getenv("MYSQLDATABASE") ?: 'photvite';

$koneksi = new mysqli($host, $user, $password, $database);

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>
