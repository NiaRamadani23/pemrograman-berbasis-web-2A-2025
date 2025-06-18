<?php
session_start();
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if ($username === "admin" && $password === "admin123") {
        $_SESSION["login"] = true;
        $_SESSION["username"] = $username;
        $_SESSION["role"] = "admin";
        header("Location: data_karyawan.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-100 via-white to-purple-200 flex items-center justify-center px-4">

    <div class="flex flex-col md:flex-row bg-white rounded-3xl shadow-2xl overflow-hidden max-w-4xl w-full">
        <div class="md:w-1/2 bg-purple-700 flex flex-col items-center justify-center p-8 relative">
            <img src="https://i.imgur.com/HrwGYbO.jpg" alt="Admin Login" class="rounded-xl shadow-lg max-w-full object-cover h-72 md:h-auto" />
        </div>
        <div class="md:w-1/2 p-10 flex flex-col justify-center">
            <h2 class="text-3xl font-extrabold text-purple-800 mb-8 text-center">Selamat Datang Admin!</h2>

            <?php if ($error): ?>
                <div class="bg-red-100 text-red-700 p-3 mb-6 rounded-lg text-center font-medium">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                <div>
                    <label for="username" class="block mb-2 font-semibold text-gray-700">Username</label>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        required 
                        autofocus
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition"
                    />
                </div>

                <div>
                    <label for="password" class="block mb-2 font-semibold text-gray-700">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition"
                    />
                </div>

                <button 
                    type="submit" 
                    class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 rounded-lg transition"
                >
                    Login
                </button>
            </form>
        </div>
    </div>

</body>
</html>
