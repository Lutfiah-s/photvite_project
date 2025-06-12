
CREATE DATABASE IF NOT EXISTS photvite;
USE photvite;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(255)
);

CREATE TABLE paket_layanan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_paket VARCHAR(100),
    deskripsi TEXT,
    harga DECIMAL(10,2)
);

CREATE TABLE galeri (
  id INT AUTO_INCREMENT PRIMARY KEY,
  judul VARCHAR(255) NOT NULL,
  gambar VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE pesanan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(100),
    email VARCHAR(100),
    no_wa INT(20),
    jenis_jasa VARCHAR(100),
    tanggal_acara DATE,
    catatan TEXT,
    tanggal_pesan TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
