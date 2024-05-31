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
</head>
<body>
<h1>Create Folder</h1>
<form action="" method="post">
    <input type="text" name="folder_name" placeholder="Folder Name" required>
    <button type="submit" name="create_folder">Create Folder</button>
</form>

<?php if ($error_message): ?>
    <p style="color: red;"><?= htmlspecialchars($error_message) ?></p>
<?php endif; ?>

<h2>Your Folders</h2>
<ul>
    <?php if ($folders): ?>
        <?php foreach ($folders as $folder): ?>
            <li><a href="folder.php?folder_id=<?= $folder['id'] ?>"><?= htmlspecialchars($folder['name']) ?></a></li>
        <?php endforeach; ?>
    <?php else: ?>
        <li>No folders found.</li>
    <?php endif; ?>
</ul>
</body>
</html>
