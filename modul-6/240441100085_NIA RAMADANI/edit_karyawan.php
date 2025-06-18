<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$nip = $_GET['nip'] ?? '';
$tab = $_GET['tab'] ?? 'semua';
$tanggal = date('Y-m-d');

if (!$nip) {
    echo "NIP tidak ditemukan!";
    exit;
}

if ($tab === 'absen') {
    $result = mysqli_query($conn, "
        SELECT a.*, k.nama 
        FROM absensi a 
        JOIN karyawan_absensi k ON a.nip = k.nip
        WHERE a.nip = '$nip' AND a.tanggal_absensi = '$tanggal'
    ");
} else {
    $result = mysqli_query($conn, "SELECT * FROM karyawan_absensi WHERE nip = '$nip'");
}

$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo $tab === 'absen' ? "Data absensi tidak ditemukan!" : "Data karyawan tidak ditemukan!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($tab === 'absen') {
        $keterangan = $_POST['keterangan'];
        $update = mysqli_query($conn, "
            UPDATE absensi SET keterangan = '$keterangan'
            WHERE nip = '$nip' AND tanggal_absensi = '$tanggal'
        ");
    } else {
        $nama = $_POST['nama'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $umur = $_POST['umur'];
        $kota_asal = $_POST['kota_asal'];
        $jabatan = $_POST['jabatan'];
        $departemen = $_POST['departemen'];

        $update = mysqli_query($conn, "
            UPDATE karyawan_absensi SET
                nama = '$nama',
                jenis_kelamin = '$jenis_kelamin',
                umur = '$umur',
                kota_asal = '$kota_asal',
                jabatan = '$jabatan',
                departemen = '$departemen'
            WHERE nip = '$nip'
        ");
    }

    if ($update) {
        header("Location: data_karyawan.php?tab=$tab");
        exit;
    } else {
        $error = "Gagal memperbarui data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit <?= $tab === 'absen' ? 'Keterangan Absensi' : 'Data Karyawan' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 py-10">

<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold text-purple-800 mb-4">
        <?= $tab === 'absen' ? 'Edit Keterangan Absensi' : 'Edit Data Karyawan' ?>
    </h2>

    <?php if (isset($error)): ?>
        <div class="bg-red-100 text-red-700 p-2 mb-4 rounded"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-4">
            <label class="block font-medium mb-1">NIP</label>
            <input type="text" value="<?= htmlspecialchars($data['nip']) ?>" class="w-full p-2 border rounded bg-gray-100" readonly>
        </div>

        <?php if ($tab === 'absen'): ?>
            <div class="mb-4">
                <label class="block font-medium mb-1">Nama</label>
                <input type="text" value="<?= htmlspecialchars($data['nama']) ?>" class="w-full p-2 border rounded bg-gray-100" readonly>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Tanggal</label>
                <input type="text" value="<?= htmlspecialchars($data['tanggal_absensi']) ?>" class="w-full p-2 border rounded bg-gray-100" readonly>
            </div>

            <div class="mb-6">
                <label class="block font-medium mb-1">Keterangan</label>
                <select name="keterangan" class="w-full p-2 border rounded" required>
                    <option value="">-- Pilih Keterangan --</option>
                    <option value="Hadir" <?= $data['keterangan'] == 'Hadir' ? 'selected' : '' ?>>Hadir</option>
                    <option value="Sakit" <?= $data['keterangan'] == 'Sakit' ? 'selected' : '' ?>>Sakit</option>
                    <option value="Izin" <?= $data['keterangan'] == 'Izin' ? 'selected' : '' ?>>Izin</option>
                    <option value="Alpha" <?= $data['keterangan'] == 'Alpha' ? 'selected' : '' ?>>Alpha</option>
                </select>
            </div>
        <?php else: ?>

            <div class="mb-4">
                <label class="block font-medium mb-1">Nama</label>
                <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" class="w-full p-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="w-full p-2 border rounded" required>
                    <option value="Laki-laki" <?= $data['jenis_kelamin'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                    <option value="Perempuan" <?= $data['jenis_kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Umur</label>
                <input type="number" name="umur" value="<?= htmlspecialchars($data['umur']) ?>" class="w-full p-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Kota Asal</label>
                <input type="text" name="kota_asal" value="<?= htmlspecialchars($data['kota_asal']) ?>" class="w-full p-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Jabatan</label>
                <input type="text" name="jabatan" value="<?= htmlspecialchars($data['jabatan']) ?>" class="w-full p-2 border rounded" required>
            </div>

            <div class="mb-6">
                <label class="block font-medium mb-1">Departemen</label>
                <input type="text" name="departemen" value="<?= htmlspecialchars($data['departemen']) ?>" class="w-full p-2 border rounded" required>
            </div>
        <?php endif; ?>

        <div class="flex justify-between">
            <a href="data_karyawan.php?tab=<?= $tab ?>" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Batal</a>
            <button type="submit" class="px-4 py-2 bg-purple-700 text-white rounded hover:bg-purple-800">Simpan</button>
        </div>
    </form>
</div>

</body>
</html>
