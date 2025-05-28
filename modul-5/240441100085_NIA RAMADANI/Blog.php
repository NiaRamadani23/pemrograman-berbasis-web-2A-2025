<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Blog Reflektif</title>
    <style>
        /* Reset margin & padding */
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f6ff;
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.6;
        }
        header {
            background-color: #87bfff;
            color: white;
            padding: 20px 0;
            text-align: center;
            font-size: 2rem;
            font-weight: 700;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        nav {
            background-color: #d0e7ff;
            text-align: center;
            padding: 12px 0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        nav a {
            color: #3a77b1;
            text-decoration: none;
            margin: 0 20px;
            font-weight: 600;
            font-size: 1rem;
            transition: color 0.3s, text-decoration 0.3s;
        }
        nav a:hover {
            color: #1f4e8a;
            text-decoration: underline;
        }
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 30px;
        }
        h2 {
            color: #3a77b1;
            font-size: 2rem;
            margin-bottom: 8px;
        }
        small {
            color: #555;
            font-size: 0.9rem;
            display: block;
            margin-bottom: 20px;
        }
        p {
            text-align: justify;
            font-size: 1.1rem;
            margin-bottom: 24px;
        }
        img {
            width: 100%;
            max-width: 700px;
            max-height: 400px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        blockquote {
            background-color: #e7f0ff;
            border-left: 5px solid #3a77b1;
            padding: 18px 25px;
            font-style: italic;
            color: #336699;
            font-size: 1.1rem;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .sumber {
            font-size: 0.85rem;
            color: #555;
            margin-bottom: 40px;
        }
        .sumber a {
            color: #3a77b1;
            text-decoration: none;
        }
        .sumber a:hover {
            text-decoration: underline;
        }
        .daftar-artikel {
            border-top: 2px solid #3a77b1;
            padding-top: 25px;
        }
        .daftar-artikel h3 {
            color: #3a77b1;
            margin-bottom: 20px;
            font-size: 1.6rem;
        }
        .daftar-artikel a {
            display: inline-block;
            margin: 6px 15px 6px 0;
            padding: 10px 18px;
            background-color: #87bfff;
            color: white;
            font-weight: 600;
            border-radius: 12px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            font-size: 1rem;
        }
        .daftar-artikel a:hover {
            background-color: #6ca9f0;
        }
        @media (max-width: 768px) {
            nav a {
                margin: 0 12px;
                font-size: 0.95rem;
            }
            .container {
                padding: 0 20px;
            }
            h2 {
                font-size: 1.6rem;
            }
            p, blockquote {
                font-size: 1rem;
            }
            .daftar-artikel a {
                font-size: 0.95rem;
                padding: 8px 14px;
                margin: 6px 10px 6px 0;
            }
        }
    </style>
</head>
<body>

<header>Blog Reflektif</header>

<nav>
    <a href="Profil.php">Beranda</a>
    <a href="timeline.php">Pengalaman</a>
    <a href="Blog.php">Blog</a>
</nav>

<div class="container">
<?php
$artikel = [
    [
        "judul" => "Belajar Sepanjang Hayat",
        "tanggal" => "2024-11-20",
        "refleksi" => "Belajar tidak berhenti di kelas. Saya mulai menyadari pentingnya belajar mandiri dari berbagai sumber seperti artikel dan video tutorial.",
        "gambar" => "https://i.imgur.com/rLhmBJS.jpg",
        "kutipan" => [
            "Teruslah belajar, karena kehidupan tak pernah berhenti mengajar.",
            "Ilmu adalah cahaya yang tak akan padam.",
            "Semakin banyak belajar, semakin sadar kita akan ketidaktahuan."
        ],
        "sumber" => "https://perpusteknik.com/metode-pembelajaran-berbasis-it/"
    ],
    [
        "judul" => "Mengembangkan Soft Skill",
        "tanggal" => "2025-01-10",
        "refleksi" => "Keterampilan seperti komunikasi dan manajemen waktu sangat saya butuhkan selama kuliah. Ini tidak diajarkan secara formal, tapi sangat penting.",
        "gambar" => "https://i.imgur.com/im7i1TL.jpg",
        "kutipan" => [
            "Soft skill membentuk bagaimana kita diterima, bukan hanya seberapa pintar kita.",
            "Kepemimpinan dan empati adalah kekuatan sejati.",
            "Komunikasi efektif membuka pintu kesempatan."
        ],
        "sumber" => "https://binuscareer.com/article/317/pentingnya-softskills-untuk-kesuksesan-berkarir/"
    ],
    [
        "judul" => "Bangkit Saat Jatuh",
        "tanggal" => "2025-03-05",
        "refleksi" => "Tidak semua hal berjalan mulus. Namun dari kegagalan, saya belajar menjadi lebih kuat dan percaya diri dalam menghadapi tantangan.",
        "gambar" => "https://i.imgur.com/UdWM81W.jpg",
        "kutipan" => [
            "Kegagalan adalah kesempatan untuk memulai kembali dengan lebih cerdas.",
            "Bangkit bukan karena tak pernah jatuh, tapi karena tak mau tetap di bawah.",
            "Jangan takut gagal, takutlah jika tidak pernah mencoba."
        ],
        "sumber" => "https://binuscareer.com/article/317/pentingnya-softskills-untuk-kesuksesan-berkarir/"
    ]
];

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id >= 0 && $id < count($artikel)) {
    $data = $artikel[$id];
    $kutipanAcak = $data["kutipan"][rand(0, count($data["kutipan"]) - 1)];

    echo "<h2>{$data['judul']}</h2>";
    echo "<small>Tanggal Posting: {$data['tanggal']}</small>";
    echo "<p>{$data['refleksi']}</p>";
    echo "<img src='{$data['gambar']}' alt='Gambar artikel: {$data['judul']}'>";
    echo "<blockquote>\"$kutipanAcak\"</blockquote>";

    if (!empty($data["sumber"])) {
        echo "<p class='sumber'>Sumber referensi: <a href='{$data['sumber']}' target='_blank'>{$data['sumber']}</a></p>";
    }
} else {
    echo "<p>Artikel tidak ditemukan.</p>";
}

echo "<div class='daftar-artikel'>";
echo "<h3>Daftar Artikel</h3>";
foreach ($artikel as $index => $a) {
    echo "<a href='?id=$index'>{$a['judul']}</a>";
}
echo "</div>";
?>
</div>

</body>
</html>
