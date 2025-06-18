<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['nip'])) {
    die("NIP tidak ditemukan.");
}

$nip = $_GET['nip'];

$query = mysqli_query($conn, "SELECT * FROM karyawan_absensi WHERE nip = '$nip'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data karyawan tidak ditemukan.");
}

$tanggal = date('Y-m-d');
$cek = mysqli_query($conn, "SELECT * FROM absensi WHERE nip = '$nip' AND DATE(tanggal_absensi) = '$tanggal'");
if (mysqli_num_rows($cek) > 0) {
    echo "<script>alert('Karyawan ini sudah memiliki data absensi hari ini.'); window.location.href='data_karyawan.php?tab=absen';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $keterangan = $_POST['keterangan'];
    $jam_masuk = null;
    $jam_pulang = null;

    $stmt = $conn->prepare("INSERT INTO absensi (nip, tanggal_absensi, jam_masuk, jam_pulang, keterangan) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nip, $tanggal, $jam_masuk, $jam_pulang, $keterangan);
    $stmt->execute();

    header("Location: data_karyawan.php?tab=absen");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Keterangan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

<div class="bg-white p-6 rounded shadow-md w-full max-w-md">
    <h2 class="text-xl font-bold mb-4">Input Keterangan Absen</h2>
    <form method="post">
        <p class="mb-2"><strong><?= htmlspecialchars($data['nama']) ?> (<?= htmlspecialchars($data['nip']) ?>)</strong></p>
        <label class="block mb-2 text-sm font-medium">Keterangan</label>
        <select name="keterangan" required class="w-full p-2 border rounded mb-4">
            <option value="">-- Pilih --</option>
            <option value="Hadir">Hadir</option>
            <option value="Izin">Izin</option>
            <option value="Sakit">Sakit</option>
            <option value="Alpha">Alpha</option>

        </select>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
    </form>
</div>

</body>
</html>
