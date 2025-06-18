<?php
session_start();
$koneksi = new mysqli("localhost", "root", "", "manajemen_karyawan");

$pesan = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mode = $_POST['mode'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($mode === "register") {
        $nama_lengkap = $_POST['nama_lengkap'] ?? '';

        if (empty($nama_lengkap)) {
            $pesan = "❌ Mohon lengkapi Nama Lengkap.";
        } else {
            $check = $koneksi->prepare("SELECT id FROM users WHERE username = ?");
            $check->bind_param("s", $username);
            $check->execute();
            $check->store_result();

            if ($check->num_rows > 0) {
                $pesan = "❌ Username sudah terdaftar.";
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $koneksi->prepare("INSERT INTO users (username, password, nama) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $username, $hash, $nama_lengkap);

                if ($stmt->execute()) {
                    $pesan = "✅ Registrasi berhasil. Silakan login.";
                } else {
                    $pesan = "❌ Registrasi gagal: " . $stmt->error;
                }
                $stmt->close();
            }
            $check->close();
        }
    } else {
        $stmt = $koneksi->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $hash);

        if ($stmt->num_rows > 0) {
            $stmt->fetch();
            if (password_verify($password, $hash)) {
                $_SESSION["login"] = true;
                $_SESSION["username"] = $username;
                $_SESSION["pesan"] = "✅ Login berhasil!";
                header("Location: input_karyawan.php");
                exit;
            } else {
                $pesan = "❌ Password salah.";
            }
        } else {
            $pesan = "❌ Akun tidak ditemukan.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login/Register | Antarna Group</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-100 to-white flex items-center justify-center p-4">
  <div class="bg-white shadow-2xl rounded-2xl overflow-hidden w-full max-w-4xl grid grid-cols-1 md:grid-cols-2">
    <div class="bg-purple-600 text-white flex flex-col items-center p-8">
      <img src="https://imgur.com/mZsQNvr.jpg" alt="Tim Kerja" class="w-80 rounded-lg shadow-lg mb-6" />
      <h2 class="text-xl font-semibold text-center leading-snug">Bersama Kita Bisa<br><span class="text-yellow-300">Membangun Masa Depan Perusahaan</span></h2>
    </div>
    <div class="p-8">
      <h2 class="text-2xl font-bold text-center mb-6 text-purple-700">Selamat Datang di Portal<br>PT. Antarna Group</h2>

      <?php if (!empty($pesan)): ?>
        <?php
          $isSuccess = str_starts_with($pesan, "✅");
          $bgClass = $isSuccess ? "bg-green-100 border-green-400 text-green-700" : "bg-red-100 border-red-400 text-red-700";
        ?>
        <div class="<?= $bgClass ?> border px-4 py-3 rounded mb-4"><?= htmlspecialchars($pesan) ?></div>
      <?php endif; ?>

      <form action="#" method="POST" class="space-y-4">
        <input type="hidden" name="mode" id="mode" value="login" />

        <div id="field-nama" class="hidden">
          <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
          <input type="text" name="nama_lengkap" class="w-full border border-gray-300 rounded p-2" />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Username</label>
          <input type="text" name="username" class="w-full border border-gray-300 rounded p-2" required />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Password</label>
          <input type="password" name="password" class="w-full border border-gray-300 rounded p-2" required />
        </div>

        <button type="submit" class="w-full bg-purple-600 text-white font-semibold py-2 rounded hover:bg-purple-700 transition">
          Login
        </button>
      </form>

      <p class="text-sm text-center mt-4 text-gray-700">
        <span id="auth-text">Belum punya akun?</span>
        <a href="#" id="switch-mode" class="text-purple-600 hover:underline">Buat akun baru</a>
      </p>
    </div>
  </div>

  <script>
    const modeInput = document.getElementById('mode');
    const btnSubmit = document.querySelector('button[type="submit"]');
    const authText = document.getElementById('auth-text');
    const switchModeLink = document.getElementById('switch-mode');
    const fieldNama = document.getElementById('field-nama');

    function updateFormMode() {
      const isLogin = modeInput.value === 'login';
      btnSubmit.textContent = isLogin ? 'Login' : 'Daftar';
      authText.textContent = isLogin ? 'Belum punya akun?' : 'Sudah punya akun?';
      switchModeLink.textContent = isLogin ? 'Buat akun baru' : 'Masuk ke akun';
      fieldNama.classList.toggle('hidden', isLogin);
    }

    switchModeLink.addEventListener('click', function (e) {
      e.preventDefault();
      modeInput.value = modeInput.value === 'login' ? 'register' : 'login';
      updateFormMode();
    });

    updateFormMode();
  </script>
</body>
</html>
