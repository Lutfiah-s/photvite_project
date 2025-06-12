<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../config.php';

// Ambil semua vendor
$result = mysqli_query($conn, "SELECT id, password FROM vendor");

while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['id'];
    $password_plain = $row['password'];

    // Jika belum di-hash (deteksi panjang & format)
    if (strlen($password_plain) < 60 || !preg_match('/^\$2y\$/', $password_plain)) {
        $password_hash = password_hash($password_plain, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE vendor SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $password_hash, $id);
        $stmt->execute();

        echo "✅ Password vendor ID $id sudah di-hash.<br>";
    } else {
        echo "ℹ️ Password vendor ID $id sudah hash.<br>";
    }
}
?>
