<?php
session_start();
include '../config.php';

if (!isset($_SESSION['vendor'])) {
  header("Location: login.php");
  exit;
}

$nama = $_POST['nama'];
$harga = $_POST['harga'];
$deskripsi = $_POST['deskripsi'];
$vendor_id = $_SESSION['vendor'];

// Upload gambar
$gambar = $_FILES['gambar']['name'];
$tmp_name = $_FILES['gambar']['tmp_name'];
$upload_dir = "../vendor/template_uploads/";
move_uploaded_file($tmp_name, $upload_dir . $gambar);

// Simpan ke database
$stmt = $conn->prepare("INSERT INTO templates (nama, harga, deskripsi, gambar, vendor) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sissi", $nama, $harga, $deskripsi, $gambar, $vendor_id);
$stmt->execute();

$_SESSION['success'] = "Template berhasil diupload!";
header("Location: dashboard.php");
exit;
?>
s
