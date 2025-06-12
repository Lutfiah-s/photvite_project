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

$pesanan = null;
$kode_ditemukan = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $kode = strtoupper(trim($_POST['kode_pesanan']));
  if (preg_match('/^ORD(\d+)$/', $kode, $matches)) {
    $id = (int)$matches[1];
    $query = $conn->query("SELECT * FROM pesanan WHERE id = $id");
    if ($query->num_rows > 0) {
      $pesanan = $query->fetch_assoc();
      $kode_ditemukan = true;
    }
  }
}
?>

<div class="container mt-5 mb-5">
  <h2 class="mb-4">🔍 Cek Status Pesanan</h2>

  <form method="POST" class="mb-4">
    <div class="input-group" style="max-width: 400px;">
      <input type="text" name="kode_pesanan" class="form-control" placeholder="Masukkan Kode Pesanan (misal: ORD123)" required>
      <button type="submit" class="btn btn-primary">Cek Status</button>
    </div>
  </form>

  <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
    <?php if ($kode_ditemukan) : ?>
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="text-success">✅ Pesanan Ditemukan</h5>
          <p><strong>Status:</strong> 
            <?php
              $status = $pesanan['status'];
              if ($status === 'pending') echo "<span class='badge bg-warning text-dark'>Menunggu Diproses</span>";
              elseif ($status === 'diproses') echo "<span class='badge bg-info text-dark'>Sedang Diproses</span>";
              elseif ($status === 'selesai') echo "<span class='badge bg-success'>Selesai</span>";
              elseif ($status === 'ditolak') echo "<span class='badge bg-danger'>Ditolak</span>";
              else echo $status;
            ?>
          </p>

          <?php if ($status === 'selesai' && !empty($pesanan['link_undangan'])) : ?>
            <p><strong>Link Undangan:</strong><br>
              <a href="<?= htmlspecialchars($pesanan['link_undangan']) ?>" class="btn btn-sm btn-success" target="_blank">🔗 Buka Undangan</a>
            </p>
          <?php elseif ($status === 'ditolak') : ?>
            <p class="text-danger">Pesanan Anda ditolak. Silakan hubungi admin untuk info lebih lanjut.</p>
          <?php else : ?>
            <p>Silakan tunggu proses verifikasi dan pembuatan undangan oleh tim kami.</p>
          <?php endif; ?>

          <hr>
          <p><strong>Nama:</strong> <?= htmlspecialchars($pesanan['nama_lengkap']) ?></p>
          <p><strong>Email:</strong> <?= htmlspecialchars($pesanan['email']) ?></p>
          <p><strong>No WA:</strong> <?= htmlspecialchars($pesanan['no_wa']) ?></p>
          <p><strong>Tanggal Acara:</strong> <?= htmlspecialchars($pesanan['tanggal_acara']) ?></p>
        </div>
      </div>
    <?php else : ?>
      <div class="alert alert-danger">❌ Kode pesanan tidak ditemukan atau salah format. Pastikan Anda menulisnya seperti: <strong>ORD123</strong></div>
    <?php endif; ?>
  <?php endif; ?>
</div>

<?php include 'template/footer.php'; ?>
