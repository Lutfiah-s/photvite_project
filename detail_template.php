<?php
include 'config.php';
include 'template/header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$template = $conn->query("SELECT t.*, v.nama AS nama_vendor, v.email AS email_vendor 
                          FROM templates t 
                          LEFT JOIN vendor v ON t.vendor = v.id 
                          WHERE t.id = $id")->fetch_assoc();

if (!$template) {
  echo "<h3>Template tidak ditemukan.</h3>";
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Detail Template - <?= htmlspecialchars($template['nama']) ?></title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f9f9f9;
      color: #333;
      line-height: 1.6;
    }

    .container {
      max-width: 900px;
    }

    .card {
      display: grid;
      grid-template-columns: 1fr 1fr;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      background-color: #fff;
      overflow: hidden;
    }

    .template-image {
      width: 65%;
      height: auto;
      border-top-left-radius: 12px;
      border-bottom-left-radius: 12px;
      display: block;
      object-fit: contain;
      background-color: #f0f0f0;
    }

    .card-body {
      padding: 2rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    h2 {
      font-weight: 700;
      margin-bottom: 0.5rem;
      color: #222;
    }

    .vendor-info {
      font-size: 0.9rem;
      color: #777;
      margin-bottom: 1.5rem;
    }

    p.description {
      font-size: 1rem;
      color: #555;
      white-space: pre-line;
    }

    .btn-pink {
      background-color: #e91e63;
      color: #fff;
      border: none;
      font-weight: 600;
      padding: 0.6rem 1.6rem;
      border-radius: 50px;
      transition: background-color 0.3s ease;
      text-decoration: none;
      width: fit-content;
    }

    .btn-pink:hover,
    .btn-pink:focus {
      background-color: #d81b60;
      color: #fff;
      outline: none;
      box-shadow: 0 0 8px rgba(216, 27, 96, 0.5);
      text-decoration: none;
    }

    /* Responsive untuk layar kecil */
    @media (max-width: 767px) {
      .card {
        grid-template-columns: 1fr;
      }
      .template-image {
        border-radius: 12px 12px 0 0;
      }
      .card-body {
        padding: 1.5rem;
      }
    }
  </style>
</head>
<body>

<div class="container py-5">
  <div class="card">
    <div>
      <img 
        src="vendor/template_uploads/<?= htmlspecialchars($template['gambar']) ?>" 
        alt="<?= htmlspecialchars($template['nama']) ?>" 
        class="template-image"
      />
    </div>
    <div class="card-body">
      <h2><?= htmlspecialchars($template['nama']) ?></h2>
      <p class="vendor-info">Oleh: <strong><?= htmlspecialchars($template['nama_vendor']) ?></strong></p>
      <p class="description"><?= nl2br(htmlspecialchars($template['deskripsi'] ?? 'Template undangan digital berkualitas tinggi, siap pakai.')) ?></p>
      <a href="pesan.php?template_id=<?= $template['id'] ?>" class="btn btn-pink mt-4">Pesan Sekarang</a>
    </div>
  </div>
</div>

<div class="card-body">
  <p><strong>Harga:</strong> Rp<?= number_format($template['harga'], 0, ',', '.') ?></p>
</div>


<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include 'template/footer.php'; ?>
