<?php
session_start();
if (!isset($_SESSION['vendor'])) {
  header("Location: ../login.php");
  exit;
}
include 'config.php';

$vendor_id = $_SESSION['vendor']['id'];

// Handle upload gambar portofolio
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['gambar'])) {
  $judul = $_POST['judul'];
  $nama_file = $_FILES['gambar']['name'];
  $tmp = $_FILES['gambar']['tmp_name'];
  
  // Validasi ekstensi file
  $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
  $file_extension = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
  
  if (in_array($file_extension, $allowed_extensions)) {
    $upload_path = "uploads/" . uniqid() . '_' . $nama_file; // Tambahkan uniqid untuk menghindari nama file duplikat
    if (move_uploaded_file($tmp, $upload_path)) {
      $stmt = $conn->prepare("INSERT INTO portofolio (vendor, judul, gambar) VALUES (?, ?, ?)");
      $stmt->bind_param("iss", $vendor_id, $judul, $upload_path);
      $stmt->execute();
      $_SESSION['success'] = "Gambar berhasil diupload!";
    } else {
      $_SESSION['error'] = "Gagal mengupload gambar.";
    }
  } else {
    $_SESSION['error'] = "Hanya file JPG, JPEG, PNG, dan GIF yang diperbolehkan.";
  }
  header("Location: ".$_SERVER['PHP_SELF']);
  exit;
}

// Hapus gambar portofolio
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus_portofolio_id'])) {
  $hapus_id = $_POST['hapus_portofolio_id'];
  $cek = $conn->prepare("SELECT gambar FROM portofolio WHERE id = ? AND vendor = ?");
  $cek->bind_param("ii", $hapus_id, $vendor_id);
  $cek->execute();
  $result = $cek->get_result();
  
  if ($row = $result->fetch_assoc()) {
    if (file_exists($row['gambar'])) {
      unlink($row['gambar']);
    }
    $hapus = $conn->prepare("DELETE FROM portofolio WHERE id = ? AND vendor = ?");
    $hapus->bind_param("ii", $hapus_id, $vendor_id);
    $hapus->execute();
    $_SESSION['success'] = "Portofolio berhasil dihapus!";
  } else {
    $_SESSION['error'] = "Portofolio tidak ditemukan atau tidak memiliki akses.";
  }
  header("Location: ".$_SERVER['PHP_SELF']);
  exit;
}

// Hapus template
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus_template_id'])) {
  $hapus_id = $_POST['hapus_template_id'];
  $cek = $conn->prepare("SELECT gambar FROM templates WHERE id = ? AND vendor_id = ?");
  $cek->bind_param("ii", $hapus_id, $vendor_id);
  $cek->execute();
  $result = $cek->get_result();
  
  if ($row = $result->fetch_assoc()) {
    if (file_exists("template_uploads/" . $row['gambar'])) {
      unlink("template_uploads/" . $row['gambar']);
    }
    $hapus = $conn->prepare("DELETE FROM templates WHERE id = ? AND vendor_id = ?");
    $hapus->bind_param("ii", $hapus_id, $vendor_id);
    $hapus->execute();
    $_SESSION['success'] = "Template berhasil dihapus!";
  } else {
    $_SESSION['error'] = "Template tidak ditemukan atau tidak memiliki akses.";
  }
  header("Location: ".$_SERVER['PHP_SELF']);
  exit;
}

// Ambil semua template dari tabel templates
$sql_templates = "SELECT * FROM templates WHERE vendor = ? ORDER BY id DESC";
$stmt_templates = $conn->prepare($sql_templates);
$stmt_templates->bind_param("i", $vendor_id);
$stmt_templates->execute();
$result_templates = $stmt_templates->get_result();

// Ambil semua portofolio dari vendor
$sql_portofolio = "SELECT * FROM portofolio WHERE vendor_id = ? ORDER BY id DESC";
$stmt_portofolio = $conn->prepare($sql_portofolio);
$stmt_portofolio->bind_param("i", $vendor_id);
$stmt_portofolio->execute();
$result_portofolio = $stmt_portofolio->get_result();
?>

<div class="container mt-4">
  <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
  <?php endif; ?>
  
  <?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
  <?php endif; ?>

  <h2>Kelola Portofolio</h2>
  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label class="form-label">Judul Foto</label>
      <input type="text" name="judul" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Upload Gambar</label>
      <input type="file" name="gambar" class="form-control" accept="image/*" required>
    </div>
    <button type="submit" class="btn btn-success">Upload</button>
  </form>

  <hr>
  
  <h3>Portofolio Saya</h3>
  <div class="row">
    <?php if ($result_portofolio->num_rows > 0): ?>
      <?php while($row = $result_portofolio->fetch_assoc()): ?>
        <div class="col-md-3 mb-3">
          <div class="card h-100">
            <img src="<?= htmlspecialchars($row['gambar']) ?>" alt="<?= htmlspecialchars($row['judul']) ?>" class="card-img-top img-fluid">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($row['judul']) ?></h5>
              <form method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus portofolio ini?')">
                <input type="hidden" name="hapus_portofolio_id" value="<?= $row['id'] ?>">
                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
              </form>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="col-12">
        <p class="text-muted">Belum ada portofolio yang tersedia.</p>
      </div>
    <?php endif; ?>
  </div>

  <hr>
  
  <h3>Template Saya</h3>
  <div class="row">
    <?php if ($result_templates->num_rows > 0): ?>
      <?php while ($row = $result_templates->fetch_assoc()): ?>
        <div class="col-md-3 mb-3">
          <div class="card h-100">
            <img src="template_uploads/<?= htmlspecialchars($row['gambar']) ?>" alt="<?= htmlspecialchars($row['nama']) ?>" class="card-img-top img-fluid">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($row['nama']) ?></h5>
              <p class="card-text">Oleh: <?= htmlspecialchars($row['vendor']) ?></p>
              <p class="card-text">Harga: Rp<?= number_format($row['harga'], 0, ',', '.') ?></p>
              <form method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus template ini?')">
                <input type="hidden" name="hapus_template_id" value="<?= $row['id'] ?>">
                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
              </form>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="col-12">
        <p class="text-muted">Belum ada template yang tersedia.</p>
      </div>
    <?php endif; ?>
  </div>
</div>
