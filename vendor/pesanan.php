<?php
session_start();
include '../config.php';

if (!isset($_SESSION['vendor'])) {
  header("Location: login.php");
  exit;
}

$vendor_id = $_SESSION['vendor'];

// Proses aksi konfirmasi atau selesai
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $pesanan_id = (int)$_POST['pesanan_id'];
  
  if (isset($_POST['konfirmasi'])) {
    $conn->query("UPDATE pesanan SET status = 'diproses' WHERE id = $pesanan_id AND vendor_id = $vendor_id");
  }

  if (isset($_POST['selesai']) && !empty($_POST['link_undangan'])) {
    $link_undangan = trim($_POST['link_undangan']);
    $stmt = $conn->prepare("UPDATE pesanan SET status = 'selesai', link_undangan = ? WHERE id = ? AND vendor_id = ?");
    $stmt->bind_param("sii", $link_undangan, $pesanan_id, $vendor_id);
    $stmt->execute();
  }
}

// Ambil semua pesanan
$query = "SELECT p.*, t.nama AS nama_template 
          FROM pesanan p 
          LEFT JOIN templates t ON p.template_id = t.id 
          WHERE p.vendor_id = ? 
          ORDER BY p.id DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $vendor_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard Vendor - Pesanan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5 mb-5">
  <h2 class="mb-4">📦 Pesanan Masuk</h2>

  <table class="table table-bordered table-striped align-middle">
    <thead class="table-light">
      <tr>
        <th>#</th>
        <th>Template</th>
        <th>Tanggal</th>
        <th>Waktu</th>
        <th>Lokasi</th>
        <th>Catatan</th>
        <th>Status</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no = 1;
      while ($row = $result->fetch_assoc()):
      ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($row['nama_template']) ?></td>
        <td><?= date("d-m-Y", strtotime($row['tanggal_acara'])) ?></td>
        <td><?= htmlspecialchars($row['waktu_acara']) ?></td>
        <td><?= nl2br(htmlspecialchars($row['lokasi_acara'])) ?></td>
        <td><?= nl2br(htmlspecialchars($row['catatan'])) ?></td>
        <td>
          <?php
          if ($row['status'] == 'pending') {
            echo '<span class="badge bg-warning text-dark">Pending</span>';
          } elseif ($row['status'] == 'diproses') {
            echo '<span class="badge bg-primary">Diproses</span>';
          } elseif ($row['status'] == 'selesai') {
            echo '<span class="badge bg-success">Selesai</span><br>';
            echo "<small><a href='" . htmlspecialchars($row['link_undangan']) . "' target='_blank'>Lihat Undangan</a></small>";
          }
          ?>
        </td>
        <td>
          <?php if ($row['status'] === 'pending'): ?>
            <form method="POST">
              <input type="hidden" name="pesanan_id" value="<?= $row['id'] ?>">
              <button type="submit" name="konfirmasi" class="btn btn-sm btn-success">Konfirmasi</button>
            </form>
          <?php elseif ($row['status'] === 'diproses'): ?>
            <form method="POST" class="d-flex flex-column gap-2">
              <input type="hidden" name="pesanan_id" value="<?= $row['id'] ?>">
              <input type="url" name="link_undangan" class="form-control form-control-sm" placeholder="Link Undangan" required>
              <button type="submit" name="selesai" class="btn btn-sm btn-primary">Selesai</button>
            </form>
          <?php else: ?>
            <em class="text-muted">-</em>
          <?php endif; ?>
        </td>
      </tr>
      <?php endwhile; ?>
      <?php if ($result->num_rows === 0): ?>
      <tr>
        <td colspan="8" class="text-center">Belum ada pesanan.</td>
      </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
</body>
</html>
