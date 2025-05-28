<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Interaktif Mahasiswa</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f6ff;
            margin: 0;
            padding: 0;
            padding-top: 130px;
        }

        header {
            background-color: #87bfff;
            color: #fff;
            padding: 25px 0;
            text-align: center;
            font-size: 24px;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1001;
        }

        nav {
            background-color: #c5ddff;
            padding: 12px;
            text-align: center;
            position: fixed;
            top: 70px;
            width: 100%;
            z-index: 1000;
        }

        nav a {
            color: #333;
            text-decoration: none;
            margin: 0 15px;
            font-weight: 600;
        }

        .container {
            background-color: white;
            width: 85%;
            margin: 30px auto;
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        h2 {
            color: #508ed4;
            border-bottom: 2px solid #dbe9ff;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table th, table td {
            border: 1px solid #cfdff3;
            padding: 10px;
        }

        table th {
            background-color: #eaf4ff;
            text-align: left;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: 600;
            color: #3a75aa;
        }

        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #aacbe6;
            border-radius: 8px;
            background-color: #f8fbff;
        }

        textarea {
            resize: none;
        }

        input[type="checkbox"],
        input[type="radio"] {
            margin-top: 10px;
        }

        input[type="submit"] {
            margin-top: 20px;
            background-color: #87bfff;
            color: white;
            padding: 10px 25px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #6ca9f0;
        }
    </style>
</head>
<body>
    <header>
         Profil Mahasiswa 
    </header>

    <nav>
        <a href="Profil.php">Halaman</a>
        <a href="timeline.php">Pengalaman</a>
        <a href="Blog.php">Blog</a>
    </nav>

    <div class="container">
        <h2>Profil Pribadi</h2>
        <table>
            <tr><th>Informasi</th><th>Detail</th></tr>
            <tr><td>Nama</td><td>Nia Ramadani</td></tr>
            <tr><td>NIM</td><td>123456789</td></tr>
            <tr><td>Tempat, Tanggal Lahir</td><td>Mojokerto, 23 Oktober 2005</td></tr>
            <tr><td>Email</td><td>niaramadani871@gmail.com</td></tr>
            <tr><td>Nomor HP</td><td>0895335638038</td></tr>
        </table>

        <h2>Formulir</h2>
        <form method="POST">
            <label>Bahasa Pemrograman yang Dikuasai:</label>
            <input type="text" name="bahasa[]">
            <input type="text" name="bahasa[]">
            <input type="text" name="bahasa[]">

            <label>Penjelasan Proyek Pribadi:</label>
            <textarea name="proyek" rows="4"></textarea>

            <label>Software yang Sering Digunakan:</label><br>
            <input type="checkbox" name="software[]" value="VS Code"> VS Code<br>
            <input type="checkbox" name="software[]" value="XAMPP"> XAMPP<br>
            <input type="checkbox" name="software[]" value="GIT"> GIT<br>
            <input type="checkbox" name="software[]" value="Figma"> Figma<br>

            <label>Sistem Operasi yang Digunakan:</label><br>
            <input type="radio" name="os" value="Windows"> Windows<br>
            <input type="radio" name="os" value="MacOS"> MacOS<br>
            <input type="radio" name="os" value="Linux"> Linux<br>

            <label>Tingkat Penguasaan PHP:</label>
            <select name="tingkat">
                <option value="">-- Pilih --</option>
                <option value="Pemula">Pemula</option>
                <option value="Menengah">Menengah</option>
                <option value="Mahir">Mahir</option>
            </select>

            <input type="submit" value="Kirim">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Validasi semua isian wajib
            $valid = true;

            if (
                empty($_POST['bahasa'][0]) && 
                empty($_POST['bahasa'][1]) && 
                empty($_POST['bahasa'][2]) ||
                empty($_POST['proyek']) ||
                empty($_POST['software']) ||
                empty($_POST['os']) ||
                empty($_POST['tingkat'])
            ) {
                echo "<p style='color:red;'>Semua kolom wajib diisi!</p>";
                $valid = false;
            }

            if ($valid) {
                echo "<h2>Hasil Input:</h2>";
                echo "<table>";
                
                // Bahasa
                $bahasa = array_filter($_POST['bahasa']);
                echo "<tr><td>Bahasa Pemrograman</td><td>" . implode(', ', array_map('htmlspecialchars', $bahasa)) . "</td></tr>";

                // Proyek
                echo "<tr><td>Proyek Pribadi</td><td>" . nl2br(htmlspecialchars($_POST['proyek'])) . "</td></tr>";

                // Software
                echo "<tr><td>Software</td><td><ul>";
                foreach ($_POST['software'] as $s) {
                    echo "<li>" . htmlspecialchars($s) . "</li>";
                }
                echo "</ul></td></tr>";

                // OS
                echo "<tr><td>Sistem Operasi</td><td>" . htmlspecialchars($_POST['os']) . "</td></tr>";

                // Tingkat
                echo "<tr><td>Tingkat Penguasaan PHP</td><td>" . htmlspecialchars($_POST['tingkat']) . "</td></tr>";

                echo "</table>";

                // Cek jumlah bahasa
                if (count($bahasa) > 2) {
                    echo "<p><strong>Anda cukup berpengalaman dalam pemrograman!</strong></p>";
                }
            }
        }
        ?>
    </div>
</body>
</html>
