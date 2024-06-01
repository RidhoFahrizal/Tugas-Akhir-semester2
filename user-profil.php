<?php
session_start();
include "Service/database.php";
include "navbar-dashboard.php";
global $dbconn, $dbname;

// Ensure user is logged in
if (isset($_SESSION['userID'])) {
    $userID = $_SESSION['userID'];

    // Query to get user data by ID
    $sql = "SELECT * FROM public.\"users\" WHERE id = $1";
    $result = pg_prepare($dbconn, "profile_query", $sql);
    $result = pg_execute($dbconn, "profile_query", array($userID));

    if ($result) {
        // Check number of rows returned
        $num_rows = pg_num_rows($result);

        if ($num_rows > 0) {
            // Fetch user data
            $row = pg_fetch_assoc($result);
        } else {
            $error = "Pengguna tidak ditemukan.";
        }
    } else {
        $error = "Terjadi kesalahan dalam mengambil data pengguna.";
    }
} else {
    $error = "Anda harus login untuk melihat profil ini.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            left: 0;
            top: 0;
            background-color: #007bff;
            color: white;
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
        .sidebar h4 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.2em;
            border-bottom: 1px solid rgba(255,255,255,0.3);
            padding-bottom: 10px;
        }
        .sidebar a {
            color: white;
            padding: 15px 20px;
            text-decoration: none;
            display: block;
            font-size: 1em;
            transition: background-color 0.3s, padding-left 0.3s;
        }
        .sidebar a:hover {
            background-color: #0056b3;
            padding-left: 30px;
        }
        .content {
            margin-left: 250px; /* Adjust based on your sidebar width */
            padding: 20px;
            flex: 1;
        }
        .profile-card {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 700px;
            margin: 2px;
        }
    </style>
</head>
<body>

<div class="content">
    <?php if (isset($row)): ?>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="profile-card">
                        <h3 class="text-center mb-4">Profil Pengguna</h3>
                        <p><strong>ID:</strong> <?php echo $row['id']; ?></p>
                        <p><strong>Username:</strong> <?php echo $row['username']; ?></p>
                        <p><strong>Email:</strong> <?php echo $row['email']; ?></p>
                        <!-- Add other columns as needed -->
                    </div>
                </div>
            </div>
        </div>
    <?php elseif (isset($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
