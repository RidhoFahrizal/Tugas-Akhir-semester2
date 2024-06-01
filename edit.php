<?php
session_start();
include "navbar-dashboard.php";
include "Service/database.php";

if (!isset($_SESSION['userID'])) {
    header('Location: login.php');
    exit();
}

$userID = $_SESSION['userID'];
$fileID = $_GET['file_id'];
$folderID = $_GET['folder_id'];

$sql_fetch_file = 'SELECT * FROM files WHERE id = $1 AND user_id = $2';
$result_fetch_file = pg_prepare($dbconn, "fetch_file", $sql_fetch_file);
$result_fetch_file = pg_execute($dbconn, "fetch_file", array($fileID, $userID));
$file = pg_fetch_assoc($result_fetch_file);

if (!$file) {
    echo "File tidak ditemukan atau Anda tidak memiliki akses.";
    exit();
}

$error_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['new_file']) && $_FILES['new_file']['error'] == 0) {
        $new_file_name = $_FILES['new_file']['name'];
        $new_file_size = $_FILES['new_file']['size'];
        $new_file_tmp = $_FILES['new_file']['tmp_name'];

        // You need to specify the path where you want to save the new file
        $upload_dir = 'uploads/';
        $new_file_path = $upload_dir . basename($new_file_name);

        if (move_uploaded_file($new_file_tmp, $new_file_path)) {
            $sql_update_file = 'UPDATE files SET file_name = $1, file_size = $2, file_path = $3 WHERE id = $4 AND user_id = $5';
            $result_update_file = pg_prepare($dbconn, "update_file", $sql_update_file);
            $result_update_file = pg_execute($dbconn, "update_file", array($new_file_name, $new_file_size, $new_file_path, $fileID, $userID));

            if ($result_update_file) {
                header("Location: folder.php?folder_id=$folderID");
                exit();
            } else {
                $error_message = 'Error updating file.';
            }
        } else {
            $error_message = 'Error uploading file.';
        }
    } else {
        $error_message = 'Please select a file to upload.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit File: <?= htmlspecialchars($file['file_name']) ?></title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Edit File: <?= htmlspecialchars($file['file_name']) ?></h1>

    <?php if ($error_message): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($error_message) ?>
        </div>
    <?php endif; ?>

    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="newFile">Select New File</label>
            <input type="file" class="form-control" id="newFile" name="new_file" required>
        </div>
        <button type="submit" class="btn btn-primary">Update File</button>
        <a href="folder.php?folder_id=<?= $folderID ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
