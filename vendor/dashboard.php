<?php
// vendor/dashboard.php
session_start();
if (!isset($_SESSION['vendor'])) {
  header("Location: login.php");
  exit;
}

include '../config.php';

// Ambil data vendor
$vendor_id = $_SESSION['vendor'];
$stmt = $conn->prepare("SELECT nama FROM vendor WHERE id = ?");
$stmt->bind_param("i", $vendor_id);
$stmt->execute();
$result = $stmt->get_result();
$vendor = $result->fetch_assoc();

// Handle delete template
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_template'])) {
    $template_id = $_POST['template_id'];
    
    $stmt = $conn->prepare("SELECT gambar FROM templates WHERE id = ? AND vendor = ?");
    $stmt->bind_param("ii", $template_id, $vendor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $template = $result->fetch_assoc();
        $file_path = "../uploads/" . $template['gambar'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        $stmt = $conn->prepare("DELETE FROM templates WHERE id = ? AND vendor = ?");
        $stmt->bind_param("ii", $template_id, $vendor_id);
        $stmt->execute();

        $_SESSION['success'] = "Template berhasil dihapus!";
        header("Location: dashboard.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Vendor</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #fce4ec, #e0f7fa);
      margin: 0;
      padding: 20px;
    }

    h2, h3 {
      text-align: center;
      color: #d81b60;
    }

    ul {
      display: flex;
      justify-content: center;
      gap: 15px;
      list-style: none;
      padding: 0;
    }

    ul li a {
      text-decoration: none;
      background-color: #81c784;
      color: white;
      padding: 10px 20px;
      border-radius: 25px;
      transition: 0.3s;
    }

    ul li a:hover {
      background-color: #66bb6a;
    }

    .alert {
      max-width: 600px;
      margin: 20px auto;
      padding: 12px;
      border-radius: 6px;
      font-weight: bold;
      text-align: center;
    }

    .alert-success {
      background-color: #e6f4ea;
      color: #2e7d32;
      border: 1px solid #a5d6a7;
    }

    .template-card {
      background: #fff;
      border: 1px solid #ddd;
      border-radius: 12px;
      padding: 20px;
      margin: 20px auto;
      max-width: 600px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }

    .template-img {
  width: 100%;
  max-width: 250px;
  height: auto;
  border-radius: 4px;
  display: block;
  margin: 0 auto 5px auto;
}


    .template-actions {
      margin-top: 10px;
    }

    .btn {
      padding: 8px 16px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
      font-size: 14px;
      margin-right: 5px;
    }

    .btn-edit {
      background-color: #64b5f6;
      color: white;
    }

    .btn-edit:hover {
      background-color: #42a5f5;
    }

    .btn-delete {
      background-color: #ef5350;
      color: white;
    }

    .btn-delete:hover {
      background-color: #e53935;
    }

    p {
      text-align: center;
      color: #555;
    }
  </style>
</head>
<body>

<h2>Selamat datang, <?= htmlspecialchars($vendor['nama']) ?></h2>

<ul>
  <li><a href="pesanan.php">Lihat Pesanan</a></li>
  <li><a href="form_input_template.php">Upload Template</a></li>
  <li><a href="logout.php">Logout</a></li>
</ul>

<?php if (isset($_SESSION['success'])): ?>
  <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>

<h3>Template Anda</h3>

<?php
$stmt2 = $conn->prepare("SELECT * FROM templates WHERE vendor = ?");
$stmt2->bind_param("i", $vendor_id);
$stmt2->execute();
$result2 = $stmt2->get_result();

if ($result2->num_rows > 0):
  while ($row = $result2->fetch_assoc()):
    $image_path = "template_uploads/" . htmlspecialchars($row['gambar']);
?>
  <div class="template-card">
    <?php if (file_exists($image_path) && is_file($image_path)): ?>
      <img src="<?= $image_path ?>" class="template-img" alt="<?= htmlspecialchars($row['nama']) ?>">
    <?php else: ?>
      <div style="background:#f8bbd0; padding:20px; text-align:center; border-radius:8px;">Gambar tidak ditemukan</div>
    <?php endif; ?>
    
    <strong><?= htmlspecialchars($row['nama']) ?></strong><br>
    Harga: Rp<?= number_format($row['harga'], 0, ',', '.') ?><br>
    Deskripsi: <?= htmlspecialchars($row['deskripsi'] ?? '-') ?><br>
    
    <div class="template-actions">
      <a href="edit_template.php?id=<?= $row['id'] ?>" class="btn btn-edit">Edit</a>
      
      <form method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus template ini?')">
        <input type="hidden" name="template_id" value="<?= $row['id'] ?>">
        <button type="submit" name="delete_template" class="btn btn-delete">Hapus</button>
      </form>
    </div>
  </div>
<?php
  endwhile;
else:
  echo "<p>Belum ada template yang diunggah.</p>";
endif;
?>

</body>
</html>
