<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit;
}
?>

<?php include 'template/header.php'; ?>

<div class="container py-5">
  <h2 class="mb-4 text-center">Dashboard Admin</h2>
  <div class="row text-center">
    <div class="col-md-4 mb-4">
      <div class="card shadow h-100">
        <div class="card-body">
          <h5 class="card-title">Data Pesanan</h5>
          <p class="card-text">Lihat dan kelola data pemesanan jasa.</p>
          <a href="pesanan.php" class="btn btn-primary">Kelola Pesanan</a>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="card shadow h-100">
        <div class="card-body">
          <h5 class="card-title">Paket Layanan</h5>
          <p class="card-text">Kelola daftar layanan fotografi dan undangan.</p>
          <a href="paket.php" class="btn btn-success">Kelola Layanan</a>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-4">
  <div class="card shadow h-100">
    <div class="card-body">
      <h5 class="card-title">Data Vendor</h5>
      <p class="card-text">Lihat dan verifikasi vendor yang mendaftar.</p>
      <a href="data_vendor.php" class="btn btn-warning">Kelola Vendor</a>
    </div>
  </div>
</div>
<div class="col-md-4 mb-4">
  <div class="card shadow h-100">
    <div class="card-body">
      <h5 class="card-title">Transaksi Vendor</h5>
      <p class="card-text">Pantau transaksi dari semua vendor.</p>
      <a href="transaksi_vendor.php" class="btn btn-info">Lihat Transaksi</a>
    </div>
  </div>
</div>


<?php include 'template/footer.php'; ?>
