<?php
session_start();
include "Service/database.php";

if (!isset($_SESSION['userID'])) {
    header('Location: login.php');
    exit();
}

$userID = $_SESSION['userID'];

if (isset($_GET['file_id'])) {
    $fileID = $_GET['file_id'];

    $sql_fetch_file = 'SELECT * FROM files WHERE id = $1 AND user_id = $2';
    $result_fetch_file = pg_prepare($dbconn, "fetch_file", $sql_fetch_file);
    $result_fetch_file = pg_execute($dbconn, "fetch_file", array($fileID, $userID));
    $file = pg_fetch_assoc($result_fetch_file);

    if ($file) {
        if (unlink($file['file_path'])) {
            $sql_delete_file = 'DELETE FROM files WHERE id = $1';
            $result_delete_file = pg_prepare($dbconn, "delete_file", $sql_delete_file);
            $result_delete_file = pg_execute($dbconn, "delete_file", array($fileID));

            if ($result_delete_file) {
                $success_message = "File berhasil dihapus.";
            } else {
                $error_message = "Gagal menghapus informasi file dari database.";
            }
        } else {
            $error_message = "Gagal menghapus file dari sistem.";
        }
    } else {
        $error_message = "File tidak ditemukan atau Anda tidak memiliki akses.";
    }
}

header('Location: folder.php?folder_id=' . $_GET['folder_id']);
exit();
?>
