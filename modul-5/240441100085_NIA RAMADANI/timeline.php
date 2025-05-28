<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Timeline Pengalaman Kuliah</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f6ff;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #87bfff;
            color: white;
            padding: 20px 0;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }

        nav {
            background-color: #d0e7ff;
            text-align: center;
            padding: 10px 0;
        }

        nav a {
            color: #3a77b1;
            text-decoration: none;
            margin: 0 15px;
            font-weight: bold;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            background: #fff;
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .timeline-item {
            margin-bottom: 30px;
        }

        .timeline-item h3 {
            margin: 0;
            color: #3a77b1;
        }

        .timeline-item small {
            color: #777;
            font-size: 12px;
        }

        .buttons {
            text-align: center;
            margin-top: 40px;
        }

        .buttons a {
            display: inline-block;
            background-color: #87bfff;
            color: white;
            padding: 10px 20px;
            margin: 0 10px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
        }

        .buttons a:hover {
            background-color: #6ca9f0;
        }
    </style>
</head>
<body>

<header>Timeline Pengalaman Kuliah</header>

<nav>
    <a href="Profil.php">Beranda</a>
    <a href="timeline.php">Pengalaman</a>
    <a href="Blog.php">Blog</a>
</nav>

<div class="container">
    <?php
    function tampilkanTimeline($timeline) {
        foreach ($timeline as $item) {
            echo "<div class='timeline-item'>";
            echo "<h3>{$item['judul']}</h3>";
            echo "<small>{$item['tanggal']}</small>";
            echo "<p style='text-align: justify;'>{$item['isi']}</p>";
            echo "</div>";
        }
    }

    $timeline = [
    [
        "judul" => "Kesan Pertama Kuliah",
        "tanggal" => "2024-08-05",
        "isi" => "Waktu pertama kali kuliah, aku campur aduk antara gugup dan excited. Jauh dari rumah, harus tinggal sendiri, dan ketemu banyak orang baru dari berbagai daerah bikin aku deg-degan. Ospek itu capek banget, tapi seru karena jadi momen kenalan dan mulai merasa punya ‘keluarga’ baru. Aku sempat nggak nyangka bakal ada diskusi kelompok sampai malam yang bikin aku mulai terbiasa dengan gaya belajar di kampus."
    ],
    [
        "judul" => "Suka Duka Jadi Mahasiswa",
        "tanggal" => "2024-02-05",
        "isi" => "Ternyata kuliah nggak sesantai yang aku kira. Tugas dan praktikum numpuk terus, kadang harus ngerjain sampai tengah malam. Pernah banget aku stres dan hampir nyerah, tapi teman-teman selalu ada buat bantu dan jadi tempat curhat. Momen santai bareng mereka, makan atau ngobrol habis kelas, jadi obat stres yang ampuh. Aku belajar buat lebih disiplin dan atur waktu supaya semua tugas bisa selesai tepat waktu."
    ],
    [
        "judul" => "Tantangan yang Dihadapi",
        "tanggal" => "2024-01-15",
        "isi" => "Salah satu hal tersulit buat aku adalah belajar hal baru yang sebelumnya nggak pernah aku sentuh, seperti coding dan logika pemrograman. Awalnya aku merasa tertinggal dan kewalahan, apalagi tugas dan ujian sering datang bersamaan. Kadang aku merasa minder karena teman-teman lain sudah lebih paham. Tapi aku belajar buat terus berusaha, mandiri, dan mengatur waktu dengan lebih baik. Semua perjuangan ini bikin aku makin kuat dan siap menghadapi tantangan ke depan."
    ]
];


    tampilkanTimeline($timeline);
    ?>

    <div class="buttons">
        <a href="Profil.php">Kembali ke Profil</a>
        <a href="Blog.php">Menuju Blog</a>
    </div>
</div>

</body>
</html>
