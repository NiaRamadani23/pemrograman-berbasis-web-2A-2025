<?php
include 'koneksi.php';

$nip = $_GET['nip'] ?? '';
if ($nip) {
  $query = "DELETE FROM karyawan_absensi WHERE nip = '$nip'";
  if (mysqli_query($conn, $query)) {
    header("Location: data_karyawan.php?tab=semua");
    exit;
  } else {
    echo "Gagal menghapus: " . mysqli_error($conn);
  }
}
?>
