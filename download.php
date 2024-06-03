<?php
session_start();
include "Service/database.php";

if (!isset($_SESSION['userID'])) {
    header('Location: login.php');
    exit();
}

$userID = $_SESSION['userID'];
$fileID = $_GET['file_id'];

// Fetch the file information from the database
$sql_fetch_file = 'SELECT * FROM files WHERE id = $1 AND user_id = $2';
$result_fetch_file = pg_prepare($dbconn, "fetch_file", $sql_fetch_file);
$result_fetch_file = pg_execute($dbconn, "fetch_file", array($fileID, $userID));
$file = pg_fetch_assoc($result_fetch_file);

if (!$file) {
    echo "File tidak ditemukan atau Anda tidak memiliki akses.";
    exit();
}

$filePath = './Uploads-dir/' . $file['file_name']; // Adjust the path as needed

if (!file_exists($filePath)) {
    echo "File tidak ditemukan di server.";
    exit();
}

// Serve the file for download
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($filePath));
readfile($filePath);
exit();
?>
