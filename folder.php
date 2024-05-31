<?php
session_start();
include "layout/navbar-dashboard.php";
include "Service/database.php";

if (!isset($_SESSION['userID'])) {
    // Jika tidak ada sesi, arahkan ke halaman login
    header('Location: login.php');
    exit();
}

$userID = $_SESSION['userID'];

// Dapatkan folder_id dari parameter URL
if (isset($_GET['folder_id'])) {
    $folderID = $_GET['folder_id'];

    // Ambil data folder dari database berdasarkan folder_id dan user_id
    $sql_fetch_folder = 'SELECT * FROM folders WHERE id = $1 AND user_id = $2';
    $result_fetch_folder = pg_prepare($dbconn, "fetch_folder", $sql_fetch_folder);
    $result_fetch_folder = pg_execute($dbconn, "fetch_folder", array($folderID, $userID));
    $folder = pg_fetch_assoc($result_fetch_folder);

    if ($folder) {
        echo "<h1>Folder: " . htmlspecialchars($folder['name']) . "</h1>";
        echo "<p>Folder ID: " . $folder['id'] . "</p>";
        echo "<p>Created at: " . $folder['created_at'] . "</p>";
    } else {
        echo "<p>Folder tidak ditemukan atau Anda tidak memiliki akses.</p>";
    }
} else {
    echo "<p>Folder ID tidak diberikan.</p>";
}
?>
