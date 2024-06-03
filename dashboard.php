
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
        }
        .welcome-message {
            justify-content: flex-start;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<?php include "navbar-dashboard.php" ?>


<div class="container-fluid content">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="welcome-message text-center">
                <h3 class="mb-4">SELAMAT DATANG DI DokumenKU <?php include "Service/welcomeUsername.php"; ?></h3>
                <p class="lead">Konten utama akan ditampilkan di sini.</p>
                <!-- Additional content can go here -->
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
