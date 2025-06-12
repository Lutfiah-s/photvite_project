<?php
$host = 'containers-us-west-200.railway.app'; // host database dari Railway
$user = 'root'; // user default
$password = 'ctLonqvoZCUnJQ'; // password dari Railway
$database = 'photvite'; // nama database kamu
$port = 3306; // port dari Railway

$conn = new mysqli($host, $user, $password, $database, $port);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
