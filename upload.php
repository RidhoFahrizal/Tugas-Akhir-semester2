<?php
session_start();
include "layout/navbar-dashboard.php";
include "Service/database.php";

if (!isset($_SESSION['userID'])) {
    header('Location: login.php');
    exit();
}

$userID = $_SESSION['userID'];

if (isset($_POST['upload_file'])) {
    $folderID = $_POST['folder_id'];

    $targetDir = "C:\\xampp\\htdocs\\Manajemen-Tugas\\Uploads-dir\\";
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    if (file_exists($targetFilePath)) {
        $error_message = "File sudah ada.";
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
            $sql = 'INSERT INTO files (user_id, folder_id, file_name, file_path, file_size, uploaded_at) VALUES ($1, $2, $3, $4, $5, NOW())';
            $result = pg_prepare($dbconn, "insert_file", $sql);
            $result = pg_execute($dbconn, "insert_file", array($userID, $folderID, $fileName, $targetFilePath, $_FILES["file"]["size"]));

            if ($result) {
                $success_message = "File berhasil diunggah.";
            } else {
                $error_message = "Gagal menyimpan informasi file.";
            }
        } else {
            $error_message = "Gagal mengunggah file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload File</title>
</head>
<body>
<h1>Upload File</h1>
<form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="folder_id" value="<?= $_GET['folder_id'] ?>">
    <input type="file" name="file" required>
    <button type="submit" name="upload_file">Upload File</button>
</form>

<?php if (isset($error_message)): ?>
    <p style="color: red;"><?= htmlspecialchars($error_message) ?></p>
<?php endif; ?>

<?php if (isset($success_message)): ?>
    <p style="color: green;"><?= htmlspecialchars($success_message) ?></p>
<?php endif; ?>
</body>
</html>
