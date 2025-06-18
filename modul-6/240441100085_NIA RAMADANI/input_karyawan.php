<?php
session_start();
date_default_timezone_set("Asia/Jakarta");

$koneksi = new mysqli("localhost", "root", "", "manajemen_karyawan");
if ($koneksi->connect_errno) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Validasi login
if (!isset($_SESSION['login']) || !isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];

// mengambil nama user 
$sql_nama = "SELECT nama FROM users WHERE username = ?";
$stmt = $koneksi->prepare($sql_nama);
if (!$stmt) die("Prepare gagal (users): " . $koneksi->error);
$stmt->bind_param("s", $username);
$stmt->execute();
$user_data = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user_data) die("User tidak ditemukan.");
$nama_user = $user_data['nama'];

// mengambil data karyawan 
$sql_karyawan = "SELECT * FROM karyawan_absensi WHERE nama = ?";
$stmt = $koneksi->prepare($sql_karyawan);
if (!$stmt) die("Prepare gagal (karyawan): " . $koneksi->error);
$stmt->bind_param("s", $nama_user);
$stmt->execute();
$data_karyawan = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$data_karyawan) die("Data karyawan tidak ditemukan.");

$nip = $data_karyawan['nip'];
$tanggal = date("Y-m-d");
$pesan = "";
$pesan_berhasil = false;

// Cek absensi hari ini
$sql_absen = "SELECT * FROM absensi WHERE nip = ? AND tanggal_absensi = ?";
$stmt = $koneksi->prepare($sql_absen);
$stmt->bind_param("ss", $nip, $tanggal);
$stmt->execute();
$absen_hari_ini = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Proses Absen
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['absen'])) {
    if (!$absen_hari_ini) {
        $jam_masuk = date("H:i:s");
        $status = "Hadir";

        $stmt = $koneksi->prepare("INSERT INTO absensi (nip, tanggal_absensi, jam_masuk, keterangan) VALUES (?, ?, ?, ?)");
        if (!$stmt) die("Prepare gagal (insert absen): " . $koneksi->error);
        $stmt->bind_param("ssss", $nip, $tanggal, $jam_masuk, $status);

        if ($stmt->execute()) {
            $pesan = "Absensi masuk berhasil dicatat pada pukul $jam_masuk.";
            $pesan_berhasil = true;
            $_SESSION['absen_berhasil'] = true;
        } else {
            $pesan = "Gagal mencatat absensi masuk: " . $stmt->error;
        }
        $stmt->close();
    } elseif ($absen_hari_ini['jam_pulang'] === null) {
        $jam_pulang = date("H:i:s");
        $stmt = $koneksi->prepare("UPDATE absensi SET jam_pulang = ? WHERE id = ?");
        $stmt->bind_param("si", $jam_pulang, $absen_hari_ini['id']);

        if ($stmt->execute()) {
            $pesan = "Absensi pulang berhasil dicatat pada pukul $jam_pulang.";
            $pesan_berhasil = true;
            $_SESSION['absen_berhasil'] = true;
        } else {
            $pesan = "Gagal mencatat absensi pulang: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $pesan = "Anda sudah selesai absen hari ini.";
    }

    // Refresh data absensi hari ini
    $stmt = $koneksi->prepare($sql_absen);
    $stmt->bind_param("ss", $nip, $tanggal);
    $stmt->execute();
    $absen_hari_ini = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Absensi Karyawan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-tr from-blue-100 to-purple-200 min-h-screen py-10 px-4">
    <div class="max-w-xl mx-auto bg-white p-6 rounded-2xl shadow-xl">
        <h2 class="text-2xl font-bold text-indigo-600 mb-4 text-center">Selamat Datang, <?= htmlspecialchars($data_karyawan['nama']) ?></h2>

        <div class="bg-gray-50 border border-gray-300 rounded-lg p-4 mb-6">
            <h3 class="text-lg font-semibold mb-2">Data Karyawan:</h3>
            <p><strong>NIP:</strong> <?= htmlspecialchars($data_karyawan['nip']) ?></p>
            <p><strong>Nama:</strong> <?= htmlspecialchars($data_karyawan['nama']) ?></p>
            <p><strong>Jenis Kelamin:</strong> <?= htmlspecialchars($data_karyawan['jenis_kelamin']) ?></p>
            <p><strong>Umur:</strong> <?= htmlspecialchars($data_karyawan['umur']) ?></p>
            <p><strong>Kota Asal:</strong> <?= htmlspecialchars($data_karyawan['kota_asal']) ?></p>
            <p><strong>Jabatan:</strong> <?= htmlspecialchars($data_karyawan['jabatan']) ?></p>
            <p><strong>Departemen:</strong> <?= htmlspecialchars($data_karyawan['departemen']) ?></p>
        </div>

        <?php if (!empty($pesan)): ?>
            <div class="bg-<?= $pesan_berhasil ? 'green' : 'red' ?>-100 border border-<?= $pesan_berhasil ? 'green' : 'red' ?>-300 text-<?= $pesan_berhasil ? 'green' : 'red' ?>-700 px-4 py-2 rounded mb-4 text-center">
                <?= htmlspecialchars($pesan) ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['absen_berhasil']) && $_SESSION['absen_berhasil'] && $absen_hari_ini): ?>
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4 text-center">
                <h3 class="font-semibold mb-2">Detail Absensi Hari Ini:</h3>
                <p><strong>Tanggal:</strong> <?= htmlspecialchars($absen_hari_ini['tanggal_absensi']) ?></p>
                <p><strong>Jam Masuk:</strong> <?= htmlspecialchars($absen_hari_ini['jam_masuk']) ?></p>
                <p><strong>Jam Pulang:</strong> <?= $absen_hari_ini['jam_pulang'] ? htmlspecialchars($absen_hari_ini['jam_pulang']) : "<em>Belum absen pulang</em>" ?></p>
                <p><strong>Keterangan:</strong> <?= htmlspecialchars($absen_hari_ini['keterangan']) ?></p>
            </div>
            <?php unset($_SESSION['absen_berhasil']); ?>
        <?php endif; ?>

        <form method="POST" class="text-center">
            <?php if (!$absen_hari_ini): ?>
                <button name="absen" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded text-sm">
                    Absen Masuk
                </button>
            <?php elseif ($absen_hari_ini['jam_pulang'] === null): ?>
                <button name="absen" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded text-sm">
                    Absen Pulang
                </button>
            <?php else: ?>
                <button disabled class="bg-gray-400 text-white px-4 py-2 rounded text-sm cursor-not-allowed">
                    Sudah Absen Hari Ini
                </button>
            <?php endif; ?>
        </form>

        <div class="text-center mt-6">
            <a href="logout.php" class="text-sm text-red-500 hover:underline">Logout</a>
        </div>
    </div>
</body>
</html>
