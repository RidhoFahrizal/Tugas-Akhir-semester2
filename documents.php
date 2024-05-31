<?php
session_start();
include "layout/navbar-dashboard.php";
include "Service/database.php";

if (!isset($_SESSION['userID'])) {
    // Jika tidak ada sesi, arahkan ke halaman login
    //header('Location: login.php');
    echo " sesi gagal";
    exit();
}

$userID = $_SESSION['userID'];

if (isset($_POST['create_folder'])){
    $name = $_POST['folder_name'];

    // Persiapkan pernyataan SQL untuk memasukkan folder baru ke dalam tabel folders
    $sql = 'INSERT INTO folders (user_id, name) VALUES ($1, $2) RETURNING id';

    // Eksekusi pernyataan SQL dengan menggunakan pg_prepare dan pg_execute
    $result = pg_prepare($dbconn, "insert_folder", $sql);
    $result = pg_execute($dbconn, "insert_folder", array($userID, $name));

    // Periksa apakah penambahan berhasil
    
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
<h2>Create Folder</h2>
<form method="POST" action="documents.php">
    <input type="text" name="folder_name" placeholder="Folder Name" required>
    <button type="submit" name="create_folder">Create Folder</button>
</form>
<h2>Your Folders</h2>
<?php if (!empty($folders)): ?>
    <ul>
        <?php foreach ($folders as $folder): ?>
            <li><a href=""><?php echo htmlspecialchars($folder['name']); ?></a></li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No folders found.</p>
<?php endif; ?>
</body>
</html>
