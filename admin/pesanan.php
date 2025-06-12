<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit;
}
include 'config.php';
?>

<!DOCTYPE html>
<html>
<head>
  <?php include 'template/header.php'; ?>
  <title>Data Pesanan - Admin</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container py-5">
  <h2 class="mb-4">Daftar Pemesanan</h2>
  <a href="index.php" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>

  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Email</th>
        <th>WA</th>
        <th>Tanggal Acara</th>
        <th>Catatan</th>
        <th>Waktu Pesan</th>
        <th>Bukti Pembayaran</th>
        <th>Status</th>
       
      </tr>
    </thead>
   <tbody>
  <?php
  $result = $conn->query("SELECT * FROM pesanan ORDER BY id DESC");
  $no = 1;
  while ($row = $result->fetch_assoc()):
  ?>
  <tr>
    <td><?= $no++ ?></td>
    <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
    <td><?= htmlspecialchars($row['email']) ?></td>
    <td><?= htmlspecialchars($row['no_wa']) ?></td>
    <td><?= htmlspecialchars($row['tanggal_acara']) ?></td>
    <td><?= nl2br(htmlspecialchars($row['catatan'])) ?></td>
    <td><?= htmlspecialchars($row['tanggal_pesan'] ?? '-') ?></td>
    <td>
      <?php if (!empty($row['bukti_bayar'])): ?>
        <a href="../uploads/<?= htmlspecialchars($row['bukti_bayar']) ?>" target="_blank">
          <img src="../uploads/<?= htmlspecialchars($row['bukti_bayar']) ?>" alt="Bukti Bayar" style="max-width:100px; border:1px solid #ccc; border-radius:4px;">
        </a>
      <?php else: ?>
        <span class="text-muted">Belum upload</span>
      <?php endif; ?>
    </td>
    <td>
  <?php
    if ($row['status'] == 'selesai') {
      echo '<span class="badge bg-success">Selesai</span><br>';
      echo "<a href='".htmlspecialchars($row['link_undangan'])."' target='_blank'>Lihat Undangan</a>";
    } elseif ($row['status'] == 'diproses') {
      echo '<span class="badge bg-primary">Diproses</span>';
    } else {
      echo '<span class="badge bg-warning text-dark">Pending</span>';
    }
  ?>
  </td>
  </tr>
  <?php endwhile; ?>
</tbody>
  </table>
</div>

<?php include 'template/footer.php'; ?>
</body>
</html>
