<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>PhotVite - Undangan Digital</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>

<?php
include 'config.php';
include 'template/header.php';

$template_id = isset($_GET['template_id']) ? (int)$_GET['template_id'] : 0;
if ($template_id <= 0) {
  echo "<div class='alert alert-danger'>Template tidak valid.</div>";
  exit;
}

$result = $conn->query("SELECT vendor FROM templates WHERE id = $template_id");
if ($result->num_rows === 0) {
  echo "<div class='alert alert-danger'>Template tidak ditemukan.</div>";
  exit;
}
$template = $result->fetch_assoc();
$vendor_id = (int)$template['vendor'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama_lengkap  = $_POST['nama_lengkap'];
  $email         = $_POST['email'];
  $no_wa         = $_POST['no_wa'];
  $tanggal_acara = $_POST['tanggal_acara'];
  $waktu_acara   = $_POST['waktu_acara'] ?? '';
  $lokasi_acara  = $_POST['lokasi_acara'] ?? '';
  $link_maps     = $_POST['link_maps'] ?? '';
  $catatan       = $_POST['catatan'] ?? '';
  $bukti_bayar   = '';
  $status        = 'pending';
  $link_undangan = '';

  // Upload bukti pembayaran
  if (isset($_FILES['bukti_bayar']) && $_FILES['bukti_bayar']['error'] == 0) {
    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
    $ext = pathinfo($_FILES['bukti_bayar']['name'], PATHINFO_EXTENSION);
    $filename = 'bukti_' . time() . '.' . $ext;
    $filepath = $upload_dir . $filename;
    if (move_uploaded_file($_FILES['bukti_bayar']['tmp_name'], $filepath)) {
      $bukti_bayar = $filename;
    }
  }

  // Simpan ke database
  $stmt = $conn->prepare("INSERT INTO pesanan (nama_lengkap, email, no_wa, tanggal_acara, waktu_acara, lokasi_acara, link_maps, catatan, vendor_id, template_id, bukti_bayar, status, link_undangan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssssssissss", $nama_lengkap, $email, $no_wa, $tanggal_acara, $waktu_acara, $lokasi_acara, $link_maps, $catatan, $vendor_id, $template_id, $bukti_bayar, $status, $link_undangan);
  $stmt->execute();

  $order_id = $conn->insert_id;
  $kode_pesanan = "ORD" . $order_id;

  echo "
  <div class='container mt-5 mb-5'>
    <div class='card shadow-sm'>
      <div class='card-body text-center'>
        <h4 class='text-success'>✅ Pesanan Berhasil Diproses</h4>
        <p class='fw-bold'>Kode Pesanan Anda: <span class='text-primary'>$kode_pesanan</span></p>
        <p>Silakan simpan kode ini untuk mengecek status pesanan Anda nanti di halaman <a href='cek-status.php'>Cek Status</a>.</p>
        <hr>
        <div class='text-start mx-auto' style='max-width:500px;'>
          <p><strong>Nama:</strong> $nama_lengkap</p>
          <p><strong>Email:</strong> $email</p>
          <p><strong>WhatsApp:</strong> $no_wa</p>
          <p><strong>Tanggal Acara:</strong> $tanggal_acara</p>
          <p><strong>Waktu:</strong> $waktu_acara</p>
          <p><strong>Lokasi:</strong> $lokasi_acara</p>
          <p><strong>Link Maps:</strong> <a href='$link_maps' target='_blank'>$link_maps</a></p>
          <p><strong>Catatan:</strong> $catatan</p>
          <p><strong>Bukti Bayar:</strong><br>
            <a href='uploads/$bukti_bayar' target='_blank'>
              <img src='uploads/$bukti_bayar' style='max-width:200px; border:1px solid #ccc; border-radius:5px;' alt='Bukti Bayar'>
            </a>
          </p>
        </div>
        <hr>
        <p class='text-muted'>Kami akan memproses pesanan Anda dan memberi update melalui halaman status.</p>
      </div>
    </div>
  </div>
  ";
  include 'template/footer.php';
  exit;
}
?>

<div class="container mt-5 mb-5">
  <h2 class="mb-4">Form Pemesanan Layanan</h2>

  <div class="alert alert-info">
    <h5>💳 Info Pembayaran</h5>
    <ul>
      <li><strong>Bank:</strong> BCA</li>
      <li><strong>No Rek:</strong> 1234567890</li>
      <li><strong>Nama:</strong> PhotVite Digital</li>
    </ul>
    <p>Atau scan QR Code berikut:</p>
    <img src="assets/qris.jpg" alt="QR Code Pembayaran" style="max-width: 300px;">
  </div>

  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3"><label>Nama Lengkap</label><input type="text" name="nama_lengkap" class="form-control" required></div>
    <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" required></div>
    <div class="mb-3"><label>Nomor WhatsApp</label><input type="text" name="no_wa" class="form-control" required></div>
    <div class="mb-3"><label>Tanggal Acara</label><input type="date" name="tanggal_acara" class="form-control" required></div>
    <div class="mb-3"><label>Waktu Acara</label><input type="time" name="waktu_acara" class="form-control"></div>
    <div class="mb-3"><label>Lokasi Acara</label><textarea name="lokasi_acara" class="form-control" required></textarea></div>
    <div class="mb-3"><label>Link Google Maps</label><input type="url" name="link_maps" class="form-control"></div>
    <div class="mb-3"><label>Catatan (Nama Pengantin / Orang Tua)</label><textarea name="catatan" class="form-control" rows="4"></textarea></div>
    <div class="mb-3"><label>Upload Bukti Pembayaran</label><input type="file" name="bukti_bayar" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required></div>
    <button type="submit" class="btn btn-success">Kirim Pesanan & Bukti Bayar</button>
  </form>
</div>

<?php include 'template/footer.php'; ?>
