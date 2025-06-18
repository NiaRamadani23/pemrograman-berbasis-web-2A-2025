<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - PT. Antarna Group</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/@phosphor-icons/web"></script>
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: url('https://imgur.com/l5cBqJL.jpg') no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
    }

    .card {
      background: rgba(255, 255, 255, 0.75);
      backdrop-filter: blur(18px);
      -webkit-backdrop-filter: blur(18px);
      border-radius: 2rem;
      box-shadow: 0 25px 40px rgba(0, 0, 0, 0.25);
      border: 1px solid rgba(255, 255, 255, 0.3);
      transition: all 0.3s ease;
    }

    .card:hover {
      box-shadow: 0 30px 50px rgba(0, 0, 0, 0.3);
    }

    .glass-button {
      transition: all 0.3s ease;
      transform: translateY(0);
    }

    .glass-button:hover {
      transform: translateY(-4px);
    }

    .ph {
      transition: transform 0.3s ease;
    }

    .group:hover .ph {
      transform: scale(1.2);
    }
  </style>
</head>
<body>

  <div class="card p-10 w-full max-w-3xl text-gray-800">
    <h1 class="text-4xl md:text-5xl font-extrabold text-center text-indigo-700 mb-3 tracking-tight drop-shadow-sm">Selamat Datang</h1>
    <h2 class="text-xl md:text-2xl font-medium text-center text-gray-700 mb-10">Di Website Resmi <span class="text-indigo-500 font-semibold">PT. Antarna Group</span></h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <a href="login.php" class="group glass-button bg-white bg-opacity-60 border border-indigo-200 rounded-2xl p-8 text-center hover:bg-indigo-600 hover:text-white shadow-lg">
        <div class="flex justify-center mb-4 text-indigo-600 group-hover:text-white text-4xl">
          <i class="ph ph-fingerprint"></i>
        </div>
        <h3 class="text-xl font-semibold mb-1">Absen</h3>
        <p class="text-sm opacity-90">Login untuk Absensi Harian</p>
      </a>

      <a href="login_admin.php" class="group glass-button bg-white bg-opacity-60 border border-yellow-200 rounded-2xl p-8 text-center hover:bg-yellow-400 hover:text-white shadow-lg">
        <div class="flex justify-center mb-4 text-yellow-500 group-hover:text-white text-4xl">
          <i class="ph ph-database"></i>
        </div>
        <h3 class="text-xl font-semibold mb-1">Update Data</h3>
        <p class="text-sm opacity-90">Login Admin untuk Edit Data</p>
      </a>
    </div>
  </div>

</body>
</html>
