<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nip = $_POST['nip'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $umur = $_POST['umur'];
    $kota_asal = $_POST['kota_asal'];
    $jabatan = $_POST['jabatan'];
    $departemen = $_POST['departemen'];

    $query = "INSERT INTO karyawan_absensi (nip, nama, jenis_kelamin, umur, kota_asal, jabatan, departemen)
              VALUES ('$nip', '$nama', '$jenis_kelamin', '$umur', '$kota_asal', '$jabatan', '$departemen')";

    if (mysqli_query($conn, $query)) {
        header("Location: data_karyawan.php?tab=semua");
        exit;
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Karyawan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 py-10">
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-lg font-bold mb-4">Tambah Data Karyawan</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="block mb-1">NIP</label>
            <input type="text" name="nip" required class="w-full border rounded px-3 py-2">
        </div>
        <div class="mb-3">
            <label class="block mb-1">Nama</label>
            <input type="text" name="nama" required class="w-full border rounded px-3 py-2">
        </div>
        <div class="mb-3">
            <label class="block mb-1">Jenis Kelamin</label>
            <select name="jenis_kelamin" required class="w-full border rounded px-3 py-2">
                <option value="">-- Pilih --</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="block mb-1">Umur</label>
            <input type="number" name="umur" required class="w-full border rounded px-3 py-2">
        </div>
        <div class="mb-3">
            <label class="block mb-1">Kota Asal</label>
            <input type="text" name="kota_asal" required class="w-full border rounded px-3 py-2">
        </div>
        <div class="mb-3">
            <label class="block mb-1">Jabatan</label>
            <input type="text" name="jabatan" required class="w-full border rounded px-3 py-2">
        </div>
        <div class="mb-4">
            <label class="block mb-1">Departemen</label>
            <input type="text" name="departemen" required class="w-full border rounded px-3 py-2">
        </div>
        <div class="flex justify-between">
            <a href="data_karyawan.php" class="text-gray-600 hover:underline">← Kembali</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
</body>
</html>
