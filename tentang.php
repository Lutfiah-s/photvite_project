<?php
include 'config.php';
include 'template/header.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Tentang PhotVite</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/style.css" />
  <style>
    .about-section {
      padding: 5rem 0;
      background-color: #f9f9f9;
    }
    
    .about-header {
      background: linear-gradient(135deg, #FF6B8B, #FF8E53);
      color: white;
      padding: 4rem 0;
      margin-bottom: 3rem;
      text-align: center;
    }
    
    .about-card {
      background: white;
      border-radius: 12px;
      padding: 2rem;
      margin-bottom: 2rem;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
      transition: transform 0.3s ease;
    }
    
    .about-card:hover {
      transform: translateY(-5px);
    }
    
    .step-number {
      display: inline-block;
      width: 40px;
      height: 40px;
      background: #FF6B8B;
      color: white;
      border-radius: 50%;
      text-align: center;
      line-height: 40px;
      font-weight: bold;
      margin-right: 15px;
    }
    
    .developer-card {
      text-align: center;
      padding: 2rem;
    }
    
    .developer-img {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      object-fit: cover;
      margin: 0 auto 1rem;
      border: 5px solid #FF6B8B;
    }
    
    .thank-you {
      background: linear-gradient(135deg, #06D6A0, #118AB2);
      color: white;
      padding: 3rem;
      border-radius: 12px;
      margin: 3rem 0;
      text-align: center;
    }
    
    .suggestion-box {
      border-left: 4px solid #FFD166;
      padding-left: 1.5rem;
      margin: 2rem 0;
    }
  </style>
</head>
<body>

<div class="about-header">
  <div class="container">
    <h1 class="display-4 fw-bold">Tentang PhotVite</h1>
    <p class="lead">Platform Undangan Digital Modern untuk Momen Spesial Anda</p>
  </div>
</div>

<div class="container about-section">
  <div class="row">
    <div class="col-lg-8 mx-auto">
      <div class="about-card">
        <h2 class="mb-4">Apa Itu PhotVite?</h2>
        <p>PhotVite adalah platform undangan digital yang memungkinkan Anda membuat undangan elektronik yang elegan dan interaktif untuk berbagai acara spesial seperti pernikahan, ulang tahun, anniversary, dan acara penting lainnya.</p>
        <p>Dengan PhotVite, Anda dapat:</p>
        <ul>
          <li>Memilih dari berbagai template profesional</li>
          <li>Menyesuaikan desain sesuai keinginan</li>
          <li>Mengirim undangan secara instan via WhatsApp, Email, atau Link</li>
          <li>Menerima konfirmasi kehadiran secara digital</li>
          <li>Mengelola daftar tamu dengan mudah</li>
        </ul>
      </div>
      
      <div class="about-card">
        <h2 class="mb-4">Tim Pengembang</h2>
        <div class="row">
          <div class="col-md-6">
            <div class="developer-card">
              <img src="assets/Lutfiah.jpg" alt="Developer" class="developer-img">
              <h4>Lutfiah Sahira</h4>
              <p class="text-muted">Lead Developer</p>
              <p>Bertanggung jawab atas arsitektur sistem dan pengembangan backend.</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="developer-card">
              <img src="assets/Sira.jpg" alt="Designer" class="developer-img">
              <h4>Lutfiah Sahira</h4>
              <p class="text-muted">UI/UX Designer</p>
              <p>Mendesain antarmuka yang indah dan pengalaman pengguna yang optimal.</p>
            </div>
          </div>
        </div>
      </div>
      
      <div class="about-card">
        <h2 class="mb-4">Cara Menggunakan PhotVite</h2>
        
        <div class="d-flex align-items-start mb-4">
          <span class="step-number">1</span>
          <div>
            <h5>Pilih Template</h5>
            <p>Telusuri koleksi template kami dan pilih yang paling sesuai dengan acara Anda.</p>
          </div>
        </div>
        
        <div class="d-flex align-items-start mb-4">
          <span class="step-number">2</span>
          <div>
            <h5>Kustomisasi</h5>
            <p>Edit teks, tambahkan foto, dan sesuaikan warna sesuai keinginan Anda.</p>
          </div>
        </div>
        
        <div class="d-flex align-items-start mb-4">
          <span class="step-number">3</span>
          <div>
            <h5>Tambah Detail Acara</h5>
            <p>Masukkan tanggal, waktu, lokasi, dan detail penting lainnya.</p>
          </div>
        </div>
        
        <div class="d-flex align-items-start mb-4">
          <span class="step-number">4</span>
          <div>
            <h5>Kirim Undangan</h5>
            <p>Bagikan undangan Anda melalui WhatsApp, Email, atau Link khusus.</p>
          </div>
        </div>
        
        <div class="d-flex align-items-start">
          <span class="step-number">5</span>
          <div>
            <h5>Kelola Tamu</h5>
            <p>Pantau daftar tamu dan konfirmasi kehadiran melalui dashboard Anda.</p>
          </div>
        </div>
      </div>
      
      <div class="thank-you">
        <h2 class="mb-3">Terima Kasih!</h2>
        <p class="lead">Kami mengucapkan terima kasih yang sebesar-besarnya kepada semua pengguna PhotVite. Dukungan Anda membuat kami terus berkembang dan berinovasi.</p>
        <p>PhotVite berkomitmen untuk terus memberikan pengalaman terbaik dalam membuat undangan digital yang memukau.</p>
      </div>
      
      <div class="suggestion-box">
        <h4 class="mb-3">Saran dari Kami</h4>
        <p>Untuk hasil terbaik:</p>
        <ul>
          <li>Gunakan foto dengan resolusi tinggi untuk kualitas tampilan optimal</li>
          <li>Persiapkan daftar tamu beserta kontak mereka sebelum membuat undangan</li>
          <li>Kirim undangan 2-3 minggu sebelum acara untuk memberi waktu cukup bagi tamu</li>
          <li>Manfaatkan fitur RSVP digital untuk memudahkan tracking kehadiran</li>
          <li>Jangan ragu menghubungi tim support kami jika mengalami kesulitan</li>
        </ul>
        <p>Kami selalu terbuka untuk masukan dan saran pengembangan. Silakan hubungi kami melalui halaman kontak.</p>
      </div>
    </div>
  </div>
</div>

<?php include 'template/footer.php'; ?>

</body>
</html>