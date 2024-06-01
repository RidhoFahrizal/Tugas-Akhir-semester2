<?php
session_start();
include "../Service/database.php";

if (!isset($_SESSION['userID'])) {
    echo "Sesi gagal";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['userID'];
    $task_description = $_POST['task_description'];

    $query = "INSERT INTO tasks (user_id, task_description, is_completed, created_at) VALUES ($1, $2, false, NOW())";
    pg_query_params($dbconn, $query, array($user_id, $task_description));

    header('Location: to-do-list.php');
    exit();
}
?>
