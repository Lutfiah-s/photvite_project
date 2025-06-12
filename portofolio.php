<?php
include 'config.php';
include 'template/header.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>PhotVite - Portofolio</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/style.css" />
  <style>
    .template-card {
      border: 1px solid #e0e0e0;
      border-radius: 10px;
      padding: 15px;
      margin-bottom: 20px;
      transition: all 0.3s ease;
      display: flex;
      flex-direction: column;
      height: 100%;
      background: white;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      overflow: hidden;
    }
    .template-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
      border-color: #007bff;
    }
    .template-img-container {
      flex: 1;
      display: flex;
      flex-direction: column;
      min-height: 200px; /* Tinggi minimum */
      max-height: 300px; /* Tinggi maksimum */
      overflow: hidden;
      border-radius: 8px;
      margin-bottom: 15px;
      background-color: #f8f9fa;
    }
    .template-img {
      width: 100%;
      height: auto;
      object-fit: contain; /* Menjaga aspek ratio gambar */
      flex: 1;
      transition: transform 0.5s ease;
    }
    .template-card:hover .template-img {
      transform: scale(1.03);
    }
    .template-content {
      flex-shrink: 0;
    }
    .no-image-placeholder {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #6c757d;
    }
  </style>
</head>
<body>

<div class="container py-5">
  <h2 class="text-center mb-5">Template Undangan Digital</h2>
  <div class="row">

  <?php
  $sql = "SELECT 
            t.*, 
            v.nama AS nama_vendor,
            v.id AS vendor_id,
            v.status AS vendor_status
          FROM 
            templates t
          LEFT JOIN 
            vendor v ON t.vendor = v.id
          WHERE 
            v.status = 'aktif' OR v.status IS NULL
          ORDER BY 
            t.id DESC";
  
  $result = $conn->query($sql);

  if ($result->num_rows > 0):
    while ($row = $result->fetch_assoc()):
      $image_path = "vendor/template_uploads/" . htmlspecialchars($row['gambar']);
      $vendor_status = $row['vendor_status'] ?? 'unknown';
      
      // Dapatkan dimensi gambar jika ada
      $image_size = @getimagesize($image_path);
      $img_style = '';
      if ($image_size) {
        $ratio = $image_size[1] / $image_size[0]; // Rasio tinggi/lebar
        $img_style = $ratio > 1 ? 'max-height: 300px; width: auto;' : 'width: 100%; height: auto;';
      }
  ?>
    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
      <div class="template-card">
        <div class="template-img-container">
          <?php if (file_exists($image_path) && is_file($image_path)): ?>
            <img src="<?= $image_path ?>" class="template-img" alt="<?= htmlspecialchars($row['nama']) ?>" style="<?= $img_style ?>">
          <?php else: ?>
            <div class="no-image-placeholder">
              <i class="fas fa-image fa-3x"></i>
            </div>
          <?php endif; ?>
        </div>
        
        <div class="template-content">
          <h5 class="mb-2"><?= htmlspecialchars($row['nama']) ?></h5>
          
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="badge bg-<?= $vendor_status === 'aktif' ? 'success' : 'secondary' ?>">
              <?= ucfirst($vendor_status) ?>
            </span>
            <span class="text-success fw-bold">Rp<?= number_format($row['harga'], 0, ',', '.') ?></span>
          </div>
          
          <p class="text-muted small mb-3">
            <i class="fas fa-user me-1"></i>
            <?= !empty($row['nama_vendor']) ? htmlspecialchars($row['nama_vendor']) : 'Vendor tidak diketahui' ?>
          </p>
          
          <div class="d-grid">
            <a href="detail_template.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">
              <i class="fas fa-eye me-1"></i> Lihat Detail
            </a>
          </div>
        </div>
      </div>
    </div>
  <?php
    endwhile;
  else:
    echo '<div class="col-12"><div class="alert alert-info text-center">Belum ada template yang tersedia.</div></div>';
  endif;
  ?>

  </div>
</div>

<?php include 'template/footer.php'; ?>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>