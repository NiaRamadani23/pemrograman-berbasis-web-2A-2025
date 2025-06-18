<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "manajemen_karyawan";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
