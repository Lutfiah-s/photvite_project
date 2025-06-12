<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: ../login.php");
  exit;
}

include 'config.php';

$query = "SELECT  t.user_id, t.total_harga, t.status, t.tanggal_pesan, v.nama AS vendor
          FROM transaksi t
          JOIN vendor v ON t.vendor_id = v.id
          ORDER BY t.tanggal_pesan DESC";

$transaksi = mysqli_query($conn, $query);
?>

<?php include 'template/header.php'; ?>
<div class="container py-5">
  <h2 class="mb-4 text-center">Transaksi Vendor</h2>
  <div class="table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Vendor</th>
          <th>Pelanggan</th>
          <th>Tanggal</th>
          <th>Total</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php while($t = mysqli_fetch_assoc($transaksi)): ?>
        <tr>
          <td><?= htmlspecialchars($t['vendor']) ?></td>
          <td><?= htmlspecialchars($t['nama_pelanggan']) ?></td>
          <td><?= htmlspecialchars($t['tanggal']) ?></td>
          <td>Rp<?= number_format($t['total'], 0, ',', '.') ?></td>
          <td>
            <?php if($t['status'] == 'selesai'): ?>
              <span class="badge bg-success">Selesai</span>
            <?php else: ?>
              <span class="badge bg-warning text-dark">Menunggu</span>
            <?php endif; ?>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include 'template/footer.php'; ?>
