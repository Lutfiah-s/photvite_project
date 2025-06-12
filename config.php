<?php
// Ambil dari environment variable Railway
$host     = getenv("MYSQLHOST");
$user     = getenv("MYSQLUSER");
$password = getenv("MYSQLPASSWORD");
$database = getenv("MYSQLDATABASE");
$port     = getenv("MYSQLPORT");

// Default jika port tidak diset
$port = $port ?: 3306;

// Buat koneksi
$conn = new mysqli($host, $user, $password, $database, $port);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
