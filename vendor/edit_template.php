<?php
session_start();
if (!isset($_SESSION['vendor'])) {
    header("Location: login.php");
    exit;
}

include '../config.php';

$vendor_id = $_SESSION['vendor'];
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data template yang akan diedit
$stmt = $conn->prepare("SELECT * FROM templates WHERE id = ? AND vendor = ?");
$stmt->bind_param("ii", $id, $vendor_id);
$stmt->execute();
$result = $stmt->get_result();
$template = $result->fetch_assoc();

if (!$template) {
    echo "<h3>Template tidak ditemukan atau Anda tidak memiliki akses.</h3>";
    exit;
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    
    // Jika upload gambar baru
    if (!empty($_FILES['gambar']['name'])) {
        $gambar = basename($_FILES['gambar']['name']);
        $upload_dir = "template_uploads/";
        $upload_path = $upload_dir . $gambar;

        move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_path);

        // Hapus gambar lama jika ada
        if (!empty($template['gambar']) && file_exists($upload_dir . $template['gambar'])) {
            unlink($upload_dir . $template['gambar']);
        }

        $stmt = $conn->prepare("UPDATE templates SET nama=?, harga=?, deskripsi=?, gambar=? WHERE id=? AND vendor=?");
        $stmt->bind_param("sissii", $nama, $harga, $deskripsi, $gambar, $id, $vendor_id);
    } else {
        $stmt = $conn->prepare("UPDATE templates SET nama=?, harga=?, deskripsi=? WHERE id=? AND vendor=?");
        $stmt->bind_param("sisii", $nama, $harga, $deskripsi, $id, $vendor_id);
    }

    if ($stmt->execute()) {
        $_SESSION['success'] = "Template berhasil diperbarui!";
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Gagal memperbarui template.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Template</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f8f8f8;
      padding: 20px;
    }

    h2 {
      text-align: center;
      color: #d81b60;
    }

    form {
      max-width: 600px;
      margin: auto;
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }

    input[type="text"],
    input[type="number"],
    textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
      margin-top: 5px;
    }

    input[type="file"] {
      margin-top: 8px;
    }

    button {
      margin-top: 20px;
      padding: 10px 20px;
      background: #4caf50;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
    }

    button:hover {
      background: #45a049;
    }

    .back-link {
      text-align: center;
      margin-top: 15px;
    }

    .back-link a {
      color: #333;
      text-decoration: none;
    }

    .back-link a:hover {
      text-decoration: underline;
    }

    .preview-img {
      max-width: 150px;
      margin-top: 10px;
      border-radius: 6px;
    }
  </style>
</head>
<body>

<h2>Edit Template</h2>

<form method="POST" enctype="multipart/form-data">
  <label>Nama Template</label>
  <input type="text" name="nama" value="<?= htmlspecialchars($template['nama']) ?>" required>

  <label>Harga (Rp)</label>
  <input type="number" name="harga" value="<?= $template['harga'] ?>" required>

  <label>Deskripsi</label>
  <textarea name="deskripsi" rows="4"><?= htmlspecialchars($template['deskripsi']) ?></textarea>

  <label>Gambar Template (Opsional)</label>
  <input type="file" name="gambar" accept="image/*">
  <?php if (!empty($template['gambar'])): ?>
    <img src="template_uploads/<?= htmlspecialchars($template['gambar']) ?>" class="preview-img">
  <?php endif; ?>

  <button type="submit">Simpan Perubahan</button>
</form>

<div class="back-link">
  <a href="dashboard.php">← Kembali ke Dashboard</a>
</div>

</body>
</html>
