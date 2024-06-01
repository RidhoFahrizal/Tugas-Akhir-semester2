<?php
session_start();
include "../navbar-dashboard.php";
include "../Service/database.php";

if (!isset($_SESSION['userID'])) {
    echo "sesi gagal";
    exit();
}

$user_id = $_SESSION['userID'];
$query = "SELECT * FROM tasks WHERE user_id = $1";
$result = pg_query_params($dbconn, $query, array($user_id));
$tasks = pg_fetch_all($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>To-Do List</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">To-Do List</h1>
    <form action="create-task.php" method="POST" class="form-inline mb-3">
        <input type="text" name="task_description" class="form-control mr-2" placeholder="New Task" required>
        <button type="submit" class="btn btn-primary">Add Task</button>
    </form>
    <ul class="list-group">
        <?php if ($tasks): ?>
            <?php foreach ($tasks as $task): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <form action="toggle-task.php" method="GET" style="display: inline;">
                            <input type="hidden" name="id" value="<?= $task['id'] ?>">
                            <input type="hidden" name="is_completed" value="<?= $task['is_completed'] == 't' ? 'false' : 'true' ?>">
                            <button type="submit" class="btn btn-sm <?= $task['is_completed'] == 't' ? 'btn-warning' : 'btn-success' ?>">
                                <?= $task['is_completed'] == 't' ? 'Undo' : 'Complete' ?>
                            </button>
                        </form>
                        <?= $task['is_completed'] == 't' ? '<s>' . htmlspecialchars($task['task_description']) . '</s>' : htmlspecialchars($task['task_description']) ?>
                    </div>
                    <div>
                        <form action="edit-task.php" method="POST" class="d-inline">
                            <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                            <input type="text" name="task_description" value="<?= htmlspecialchars($task['task_description']) ?>" required class="form-control d-inline" style="width: auto;">
                            <button type="submit" class="btn btn-sm btn-secondary">Edit</button>
                        </form>
                        <form action="delete-task.php" method="GET" class="d-inline">
                            <input type="hidden" name="id" value="<?= $task['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li class="list-group-item">No tasks found.</li>
        <?php endif; ?>
    </ul>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
