<?php
session_start();
include "Service/database.php";
global $dbconn, $dbname;

// Pastikan pengguna sudah login
if (isset($_SESSION['userID'])) {
    $userID = $_SESSION['userID'];

    // Query untuk mendapatkan data pengguna berdasarkan ID
    $sql = "SELECT * FROM public.\"users\" WHERE id = $1";
    $result = pg_prepare($dbconn, "profile_query", $sql);
    $result = pg_execute($dbconn, "profile_query", array($userID));

    if ($result) {
        // Memeriksa jumlah baris hasil
        $num_rows = pg_num_rows($result);

        if ($num_rows > 0) {
            // Mengambil data pengguna
            $row = pg_fetch_assoc($result);

            // Tampilkan data pengguna
            echo "Profil Pengguna:<br>";
            echo "ID: " . $row['id'] . "<br>";
            echo "Username: " . $row['username'] . "<br>";
            echo "Email: " . $row['email'] . "<br>";
            // Tambahkan kolom lain sesuai kebutuhan
        } else {
            echo "Pengguna tidak ditemukan.";
        }
    } else {
        echo "Terjadi kesalahan dalam mengambil data pengguna.";
    }
} else {
    echo "Anda harus login untuk melihat profil ini.";
}
?>
