<?php
session_start();
include "../Service/database.php";

if (!isset($_SESSION['userID'])) {
    echo "Sesi gagal";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = $_POST['task_id'];
    $task_description = $_POST['task_description'];

    $query = "UPDATE tasks SET task_description = $1 WHERE id = $2";
    $result = pg_query_params($dbconn, $query, array($task_description, $task_id));

    if ($result) {
        header('Location: to-do-list.php');
    } else {
        echo "Error updating task.";
    }
    exit();
}
?>
