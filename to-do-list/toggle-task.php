<?php
session_start();
include "../Service/database.php";

if (!isset($_SESSION['userID'])) {
    echo "Sesi gagal";
    exit();
}

if (isset($_GET['id'])) {
    $task_id = $_GET['id'];
    $is_completed = $_GET['is_completed'] == 'true' ? 'true' : 'false';

    $query = "UPDATE tasks SET is_completed = $1 WHERE id = $2";
    $result = pg_query_params($dbconn, $query, array($is_completed, $task_id));

    if ($result) {
        header('Location: to-do-list.php');
    } else {
        echo "Error toggling task completion.";
    }
    exit();
}
?>
