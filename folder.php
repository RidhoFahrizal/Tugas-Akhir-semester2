<?php
session_start();
include "layout/navbar-dashboard.php";
include "Service/database.php";

if (!isset($_SESSION['userID'])) {
    header('Location: login.php');
    exit();
}

$userID = $_SESSION['userID'];
$folderID = $_GET['folder_id'];
$order_by = $_GET['order_by'] ?? 'uploaded_at';
$order_direction = $_GET['order_direction'] ?? 'DESC';

$sql_fetch_folder = 'SELECT * FROM folders WHERE id = $1 AND user_id = $2';
$result_fetch_folder = pg_prepare($dbconn, "fetch_folder", $sql_fetch_folder);
$result_fetch_folder = pg_execute($dbconn, "fetch_folder", array($folderID, $userID));
$folder = pg_fetch_assoc($result_fetch_folder);

if (!$folder) {
    echo "Folder tidak ditemukan atau Anda tidak memiliki akses.";
    exit();
}

$sql_fetch_files = "SELECT * FROM files WHERE folder_id = $1 AND user_id = $2 ORDER BY $order_by $order_direction";
$result_fetch_files = pg_prepare($dbconn, "fetch_files", $sql_fetch_files);
$result_fetch_files = pg_execute($dbconn, "fetch_files", array($folderID, $userID));
$files = pg_fetch_all($result_fetch_files);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Folder: <?= htmlspecialchars($folder['name']) ?></title>
</head>
<body>
<h1>Folder: <?= htmlspecialchars($folder['name']) ?></h1>
<a href="upload.php?folder_id=<?= $folderID ?>">Upload File</a>

<h2>Files in this Folder</h2>
<form action="" method="get">
    <input type="hidden" name="folder_id" value="<?= $folderID ?>">
    <select name="order_by">
        <option value="uploaded_at" <?= $order_by == 'uploaded_at' ? 'selected' : '' ?>>Uploaded Time</option>
        <option value="file_size" <?= $order_by == 'file_size' ? 'selected' : '' ?>>File Size</option>
    </select>
    <select name="order_direction">
        <option value="ASC" <?= $order_direction == 'ASC' ? 'selected' : '' ?>>Ascending</option>
        <option value="DESC" <?= $order_direction == 'DESC' ? 'selected' : '' ?>>Descending</option>
    </select>
    <button type="submit">Sort</button>
</form>

<ul>
    <?php if ($files): ?>
        <?php foreach ($files as $file): ?>
            <li>
                <?= htmlspecialchars($file['file_name']) ?> (<?= $file['file_size'] ?> bytes)
                <a href="delete.php?file_id=<?= $file['id'] ?>&folder_id=<?= $folderID ?>">Delete</a>
            </li>
        <?php endforeach; ?>
    <?php else: ?>
        <li>No files found.</li>
    <?php endif; ?>
</ul>
</body>
</html>
