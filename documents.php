<?php
session_start();
include "navbar-dashboard.php";
include "Service/database.php";

if (!isset($_SESSION['userID'])) {
    // Jika tidak ada sesi, arahkan ke halaman login
    header('Location: login.php');
    exit();
}

$userID = $_SESSION['userID'];
$error_message = '';

if (isset($_POST['create_folder'])) {
    $name = $_POST['folder_name'];

    // Periksa apakah nama folder sudah ada untuk pengguna ini
    $sql_check_folder = 'SELECT * FROM folders WHERE user_id = $1 AND name = $2';
    $result_check_folder = pg_prepare($dbconn, "check_folder", $sql_check_folder);
    $result_check_folder = pg_execute($dbconn, "check_folder", array($userID, $name));

    if (pg_num_rows($result_check_folder) > 0) {
        // Jika sudah ada folder dengan nama yang sama
        $error_message = 'Folder dengan nama yang sama sudah ada. Silakan pilih nama lain.';
    } else {
        // Persiapkan pernyataan SQL untuk memasukkan folder baru ke dalam tabel folders
        $sql = 'INSERT INTO folders (user_id, name) VALUES ($1, $2) RETURNING id';

        // Eksekusi pernyataan SQL dengan menggunakan pg_prepare dan pg_execute
        $result = pg_prepare($dbconn, "insert_folder", $sql);
        $result = pg_execute($dbconn, "insert_folder", array($userID, $name));
    }
}

// Ambil daftar folder pengguna dari database
$sql_fetch_folders = 'SELECT * FROM folders WHERE user_id = $1';
$result_fetch_folders = pg_prepare($dbconn, "fetch_folders", $sql_fetch_folders);
$result_fetch_folders = pg_execute($dbconn, "fetch_folders", array($userID));
$folders = pg_fetch_all($result_fetch_folders);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Folder</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Create Folder</h1>
    <form action="" method="post" class="form-inline my-3">
        <div class="form-group mx-sm-3 mb-2">
            <label for="folderName" class="sr-only">Folder Name</label>
            <input type="text" class="form-control" id="folderName" name="folder_name" placeholder="Folder Name" required>
        </div>
        <button type="submit" name="create_folder" class="btn btn-primary mb-2">Create Folder</button>
    </form>

    <?php if ($error_message): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($error_message) ?>
        </div>
    <?php endif; ?>

    <h2>Your Folders</h2>
    <ul class="list-group">
        <?php if ($folders): ?>
            <?php foreach ($folders as $folder): ?>
                <li class="list-group-item"><a href="folder.php?folder_id=<?= $folder['id'] ?>"><?= htmlspecialchars($folder['name']) ?></a></li>
            <?php endforeach; ?>
        <?php else: ?>
            <li class="list-group-item">No folders found.</li>
        <?php endif; ?>
    </ul>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
