<?php
// Konfigurasi koneksi database untuk admin

$host     = getenv("MYSQLHOST");
$user     = getenv("MYSQLUSER");
$password = getenv("MYSQLPASSWORD");
$database = getenv("MYSQLDATABASE");
$port     = getenv("MYSQLPORT") ?: 3306;

$conn = new mysqli($host, $user, $password, $database, $port);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi ke database (admin) gagal: " . $conn->connect_error);
}
?>
