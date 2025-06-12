<?php
session_start();
if (!isset($_SESSION['vendor'])) {
  header("Location: login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Upload Template Baru</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h2 class="mb-4">Upload Template Baru</h2>
    <form action="simpan_template.php" method="POST" enctype="multipart/form-data" class="p-4 bg-white rounded shadow-sm">
      <div class="mb-3">
        <label class="form-label">Nama Template:</label>
        <input type="text" name="nama" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Harga (Rp):</label>
        <input type="number" name="harga" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Deskripsi:</label>
        <textarea name="deskripsi" class="form-control" rows="4" placeholder="Deskripsikan fitur atau tema template..."></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">Gambar Preview:</label>
        <input type="file" name="gambar" accept="image/*" class="form-control" required>
      </div>

      <button type="submit" class="btn btn-success">Simpan Template</button>
    </form>
  </div>
</body>
</html>
