<?php
include 'config.php';
include 'template/header.php';
?>

<style>
  .template-card img {
    height: 400px;
    width: 100%;
    object-fit: contain;
    background-color: #f8f8f8;
    padding: 8px;
  }

  .btn-pink {
    background-color: #f48fb1;
    color: white;
    border: none;
  }

  .btn-outline-pink {
    border: 1px solid #f48fb1;
    color: #f48fb1;
  }

  .btn-outline-pink:hover {
    background-color: #f48fb1;
    color: white;
  }

  .text-pink {
    color: #f48fb1;
  }

  .bg-gradient-pink {
    background: linear-gradient(135deg, #f9e5e5, #fce4ec);
  }

  .rounded-4 {
    border-radius: 1rem !important;
  }
</style>

<section class="hero d-flex align-items-center" style="min-height: 90vh; background: linear-gradient(135deg, #f9e5e5, #fff);">
  <div class="container d-flex justify-content-between align-items-center flex-wrap">
    <div class="hero-text" style="max-width: 45%;">
      <h1 class="display-3 fw-bold text-pink mb-3">Buat Undangan Digital<br>Yang Mengesankan</h1>
      <p class="lead text-muted mb-4">Desain interaktif & elegan untuk momen spesialmu. Mudah dibuat dan langsung dibagikan.</p>
      <a href="portofolio.php" class="btn btn-pink btn-lg shadow">Mulai Sekarang</a>
    </div>
    <div class="hero-media" style="max-width: 25%;">
      <img src="assets/logo.png" alt="Undangan Digital" class="img-fluid rounded shadow" />
    </div>
  </div>
</section>

<!-- Form Cek Status Pesanan -->
<section class="py-4 text-center bg-white">
  <div class="container">
    <h5 class="mb-3 text-pink">🔍 Cek Status Pesanan Anda</h5>
    <form action="cek-status.php" method="get" class="d-flex justify-content-center gap-2 flex-wrap">
      <input type="text" name="kode" class="form-control" placeholder="Masukkan Kode Pesanan (mis. ORD123)" style="max-width: 300px;" required>
      <button type="submit" class="btn btn-outline-pink">Cek</button>
    </form>
  </div>
</section>

<section class="py-5 bg-white text-center">
  <div class="container">
    <h2 class="fw-bold mb-3 text-pink">Kenapa Pilih PhotVite?</h2>
    <p class="text-muted mb-4">Platform pembuatan undangan digital dengan desain modern dan proses mudah.</p>
    <div class="row">
      <div class="col-md-4">
        <h5 class="text-pink">Desain Premium</h5>
        <p>Template menarik siap pakai untuk berbagai acara.</p>
      </div>
      <div class="col-md-4">
        <h5 class="text-pink">Langkah Mudah</h5>
        <p>Pilih desain, isi data, undanganmu siap dalam hitungan menit.</p>
      </div>
      <div class="col-md-4">
        <h5 class="text-pink">Langsung Dibagikan</h5>
        <p>Undanganmu bisa langsung dibagikan lewat WhatsApp, Instagram, dll.</p>
      </div>
    </div>
  </div>
</section>

<section id="template" class="py-5 bg-light text-center">
  <div class="container">
    <h2 class="fw-bold text-pink mb-4">Pilih Template Favoritmu</h2>
    <div class="row g-4">
      <?php
      $templates = $conn->query("SELECT t.*, v.nama AS nama_vendor 
                                 FROM templates t 
                                 LEFT JOIN vendor v ON t.vendor = v.id 
                                 WHERE v.status = 'aktif' 
                                 ORDER BY t.id DESC 
                                 LIMIT 9");
      while ($row = $templates->fetch_assoc()):
      ?>
      <div class="col-md-4 col-sm-6">
        <div class="card shadow-sm rounded-4 overflow-hidden template-card">
          <img src="vendor/template_uploads/<?= htmlspecialchars($row['gambar']) ?>" alt="<?= htmlspecialchars($row['nama']) ?>" class="img-fluid">
          <div class="card-body">
            <h5 class="fw-bold"><?= htmlspecialchars($row['nama']) ?></h5>
            <p class="text-muted small mb-1"><?= htmlspecialchars($row['nama_vendor']) ?></p>
            <a href="detail_template.php?id=<?= $row['id'] ?>" class="btn btn-outline-pink btn-sm mt-2">Lihat Detail</a>
          </div>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
    <a href="portofolio.php" class="btn btn-pink mt-4 px-5">Lihat Semua Template</a>
  </div>
</section>

<section class="py-5 bg-gradient-pink text-white text-center">
  <div class="container">
    <h2 class="fw-bold">Buat Undangan Digitalmu Sekarang</h2>
    <p class="lead mb-4">Pilih desain favorit, lengkapi data, dan langsung bagikan!</p>
  </div>
</section>

<?php include 'template/footer.php'; ?>
