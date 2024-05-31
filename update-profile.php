<?php
session_start();
include "Service/database.php";
global $dbconn;

if (isset($_POST['username']) && isset($_POST['email']) && isset($_SESSION['userID'])) {
    $username = $_POST['username'];
    $profilePicture = null;

    // Handle file upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($_FILES['profile_picture']['name']);
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadFile)) {
            $profilePicture = $uploadFile;
        }
    }

    // Update user data
    if ($profilePicture) {
        $sql = "UPDATE public.\"users\" SET username = $1, email = $2, profile_picture = $3 WHERE id = $4";
        $result = pg_prepare($dbconn, "update_profile", $sql);
        $result = pg_execute($dbconn, "update_profile", array($username, $email, $profilePicture, $userID));
    } else {
        $sql = "UPDATE public.\"users\" SET username = $1, email = $2 WHERE id = $3";
        $result = pg_prepare($dbconn, "update_profile", $sql);
        $result = pg_execute($dbconn, "update_profile", array($username, $email, $userID));
    }

    if ($result) {
        header("Location: user-profil.php");
        exit();
    } else {
        echo "Terjadi kesalahan dalam mengupdate profil.";
    }
} else {
    echo "Data tidak lengkap.";
}
?>
