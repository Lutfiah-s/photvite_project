<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: ../login.php");
  exit;
}

include 'config.php';

// Hapus vendor jika ada permintaan hapus
if (isset($_GET['hapus'])) {
  $id = intval($_GET['hapus']);
  mysqli_query($conn, "DELETE FROM vendor WHERE id=$id");
  header("Location: data_vendor.php");
  exit;
}

// Update status vendor jika ada permintaan
if (isset($_GET['verifikasi'])) {
  $id = $_GET['verifikasi'];
  mysqli_query($conn, "UPDATE vendor SET status='aktif' WHERE id=$id");
  header("Location: data_vendor.php");
  exit;
}

$vendors = mysqli_query($conn, "SELECT * FROM vendor ORDER BY status ASC, id DESC");
?>

<?php include 'template/header.php'; ?>
<div class="container py-5">
  <h2 class="mb-4 text-center">Data Vendor</h2>
  <div class="table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Email</th>
          <th>Nomor HP</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php while($v = mysqli_fetch_assoc($vendors)): ?>
        <tr>
          <td><?= htmlspecialchars($v['nama']) ?></td>
          <td><?= htmlspecialchars($v['email']) ?></td>
          <td><?= htmlspecialchars($v['no_hp']) ?></td>
          <td>
            <?php if($v['status'] == 'aktif'): ?>
              <span class="badge bg-success">Aktif</span>
            <?php else: ?>
              <span class="badge bg-warning text-dark">Menunggu</span>
            <?php endif; ?>
          </td>
          <td>
            <?php if($v['status'] != 'aktif'): ?>
              <a href="?verifikasi=<?= $v['id'] ?>" class="btn btn-sm btn-primary">Verifikasi</a>
            <?php else: ?>
              <em>-</em>
            <?php endif; ?>
             <a href="?hapus=<?= $v['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus vendor ini?');">Hapus</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include 'template/footer.php'; ?>
