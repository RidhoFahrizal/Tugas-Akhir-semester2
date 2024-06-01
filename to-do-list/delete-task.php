<?php
session_start();
include "../Service/database.php";

if (!isset($_SESSION['userID'])) {
    echo "Sesi gagal";
    exit();
}

if (isset($_GET['id'])) {
    $task_id = $_GET['id'];

    $query = "DELETE FROM tasks WHERE id = $1";
    $result = pg_query_params($dbconn, $query, array($task_id));

    if ($result) {
        header('Location: to-do-list.php');
    } else {
        echo "Error deleting task.";
    }
    exit();
}
?>
