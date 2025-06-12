<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit;
}
include '../config.php';

// Proses hapus
if (isset($_GET['hapus'])) {
  $id = intval($_GET['hapus']);
  $koneksi->query("DELETE FROM paket WHERE id=$id");
  header("Location: paket.php");
  exit;
}

// Proses tambah paket
if (isset($_POST['tambah'])) {
  $nama = $koneksi->real_escape_string($_POST['nama_paket']);
  $deskripsi = $koneksi->real_escape_string($_POST['deskripsi']);
  $harga = floatval($_POST['harga']);
  $koneksi->query("INSERT INTO paket (nama_paket, deskripsi, harga) VALUES ('$nama', '$deskripsi', $harga)");
  header("Location: paket.php");
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<?php include 'template/header.php'; ?>
  <title>Kelola Paket - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container py-5">
  <h2 class="mb-4">Kelola Paket Layanan</h2>
  <a href="dashboard.php" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>

  <!-- Form Tambah Paket -->
  <div class="card mb-4">
    <div class="card-header">Tambah Paket Baru</div>
    <div class="card-body">
      <form method="post">
        <div class="mb-3">
          <label for="nama_paket" class="form-label">Nama Paket</label>
          <input type="text" name="nama_paket" id="nama_paket" class="form-control" required />
        </div>
        <div class="mb-3">
          <label for="deskripsi" class="form-label">Deskripsi</label>
          <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3"></textarea>
        </div>
        <div class="mb-3">
          <label for="harga" class="form-label">Harga (Rp)</label>
          <input type="number" name="harga" id="harga" class="form-control" step="1000" min="0" required />
        </div>
        <button type="submit" name="tambah" class="btn btn-primary">Tambah Paket</button>
      </form>
    </div>
  </div>

  <!-- Tabel Paket -->
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>No</th>
        <th>Nama Paket</th>
        <th>Deskripsi</th>
        <th>Harga (Rp)</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $result = $koneksi->query("SELECT * FROM paket ORDER BY id DESC");
      $no = 1;
      while ($row = $result->fetch_assoc()):
      ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($row['nama_paket']) ?></td>
        <td><?= nl2br(htmlspecialchars($row['deskripsi'])) ?></td>
        <td><?= number_format($row['harga'], 0, ',', '.') ?></td>
        <td>
          <!-- Tombol Edit bisa ditambah nanti -->
          <a href="?hapus=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus paket ini?')">Hapus</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'template/footer.php'; ?>
</body>
</html>
