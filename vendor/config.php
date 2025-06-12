<?php
// Konfigurasi koneksi database untuk vendor

$host     = getenv("MYSQLHOST");
$user     = getenv("MYSQLUSER");
$password = getenv("MYSQLPASSWORD");
$database = getenv("MYSQLDATABASE");
$port     = getenv("MYSQLPORT") ?: 3306;

$conn = new mysqli($host, $user, $password, $database, $port);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi ke database (vendor) gagal: " . $conn->connect_error);
}
?>
