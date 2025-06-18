<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$allowed_tabs = ['semua', 'absen'];
$tab = in_array($_GET['tab'] ?? '', $allowed_tabs) ? $_GET['tab'] : 'semua';

$semua = mysqli_query($conn, "SELECT * FROM karyawan_absensi ORDER BY nama");

$absen = mysqli_query($conn, "
    SELECT k.*, a.tanggal_absensi, a.jam_masuk, a.jam_pulang, a.keterangan
    FROM karyawan_absensi k
    INNER JOIN absensi a ON k.nip = a.nip AND DATE(a.tanggal_absensi) = CURDATE()
    ORDER BY k.nama
");

if (!$semua || !$absen) {
    die("Query Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Data Karyawan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen font-sans text-gray-800">

<header class="bg-purple-700 text-white py-6 shadow-md">
    <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold tracking-wide">Manajemen Karyawan</h1>
        <a href="logout.php" class="bg-red-600 hover:bg-red-700 transition px-4 py-2 rounded-md text-sm font-semibold shadow-md">
            Logout
        </a>
    </div>
</header>

<div class="max-w-7xl mx-auto px-6 mt-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <nav class="flex space-x-3">
        <a href="?tab=semua"
           class="px-5 py-2 rounded-md text-sm font-semibold transition
           <?= $tab === 'semua' ? 'bg-purple-700 text-white shadow-md' : 'bg-gray-200 text-gray-800 hover:bg-gray-300' ?>">
           Data Karyawan
        </a>
        <a href="?tab=absen"
           class="px-5 py-2 rounded-md text-sm font-semibold transition
           <?= $tab === 'absen' ? 'bg-purple-700 text-white shadow-md' : 'bg-gray-200 text-gray-800 hover:bg-gray-300' ?>">
           Absensi Karyawan
        </a>
    </nav>
    <?php if ($tab === 'semua'): ?>
        <a href="tambah_karyawan.php" 
           class="px-5 py-2 bg-green-600 text-white text-sm font-semibold rounded-md hover:bg-green-700 shadow-md transition">
           + Tambah Karyawan
        </a>
    <?php endif; ?>
</div>

<main class="max-w-7xl mx-auto mt-6 bg-white shadow-lg rounded-lg overflow-hidden border border-gray-200">
    <h2 class="text-center text-2xl font-semibold text-purple-800 py-5 border-b border-purple-200 select-none">
        <?= $tab === 'absen' ? 'ABSENSI KARYAWAN' : 'DATA KARYAWAN' ?>
    </h2>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-purple-600 text-white select-none">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold">NIP</th>
                    <th class="px-6 py-3 text-left font-semibold">Nama</th>
                    <th class="px-6 py-3 text-left font-semibold">Jenis Kelamin</th>
                    <th class="px-6 py-3 text-left font-semibold">Umur</th>
                    <th class="px-6 py-3 text-left font-semibold">Kota</th>
                    <th class="px-6 py-3 text-left font-semibold">Jabatan</th>
                    <th class="px-6 py-3 text-left font-semibold">Departemen</th>
                    <?php if ($tab === 'absen'): ?>
                        <th class="px-6 py-3 text-left font-semibold">Absensi</th>
                        <th class="px-6 py-3 text-left font-semibold">Keterangan</th>
                    <?php endif; ?>
                    <?php if ($tab === 'semua'): ?>
                        <th class="px-6 py-3 text-left font-semibold">Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                <?php
                $data = $tab === 'absen' ? $absen : $semua;
                if (mysqli_num_rows($data) === 0): ?>
                    <tr>
                        <td colspan="<?= $tab === 'semua' ? 8 : 9 ?>" class="text-center text-red-500 py-6 font-semibold">
                            Tidak ada data yang tersedia.
                        </td>
                    </tr>
                <?php endif; ?>

                <?php while ($row = mysqli_fetch_assoc($data)): ?>
                    <tr class="hover:bg-purple-50 transition-colors duration-150">
                        <td class="px-6 py-3 whitespace-nowrap"><?= htmlspecialchars($row['nip']) ?></td>
                        <td class="px-6 py-3 whitespace-nowrap font-medium"><?= htmlspecialchars($row['nama']) ?></td>
                        <td class="px-6 py-3 whitespace-nowrap"><?= htmlspecialchars($row['jenis_kelamin']) ?></td>
                        <td class="px-6 py-3 whitespace-nowrap"><?= htmlspecialchars($row['umur']) ?></td>
                        <td class="px-6 py-3 whitespace-nowrap"><?= htmlspecialchars($row['kota_asal']) ?></td>
                        <td class="px-6 py-3 whitespace-nowrap"><?= htmlspecialchars($row['jabatan']) ?></td>
                        <td class="px-6 py-3 whitespace-nowrap"><?= htmlspecialchars($row['departemen']) ?></td>

                        <?php if ($tab === 'absen'): ?>
                            <td class="px-6 py-3 whitespace-nowrap">
                                <?= date("Y-m-d H:i", strtotime($row['tanggal_absensi'] . ' ' . $row['jam_masuk'])) ?>
                                <?php if (!empty($row['jam_pulang'])): ?>
                                    <br><small class="text-gray-500">Pulang: <?= htmlspecialchars($row['jam_pulang']) ?></small>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap"><?= htmlspecialchars($row['keterangan'] ?? '-') ?></td>
                        <?php endif; ?>

                        <?php if ($tab === 'semua'): ?>
                            <td class="px-6 py-3 space-y-2">
                                <a href="edit_karyawan.php?nip=<?= $row['nip'] ?>" 
                                   class="inline-block text-indigo-600 hover:underline text-sm font-medium">
                                   Edit Data
                                </a>
                                <a href="edit_keterangan.php?nip=<?= $row['nip'] ?>" 
                                   class="inline-block text-blue-600 hover:underline text-sm font-medium">
                                   Edit Absen
                                </a>
                                <a href="hapus.php?nip=<?= $row['nip'] ?>" 
                                   onclick="return confirm('Yakin ingin menghapus data ini?')" 
                                   class="inline-block text-red-600 hover:underline text-sm font-medium">
                                   Hapus
                                </a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</main>

</body>
</html>
