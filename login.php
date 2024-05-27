<?php
include "Service/database.php";
global $dbconn, $dbname;
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query untuk mencari pengguna dengan email dan password yang sesuai
    $sql = "SELECT * FROM public.\"user\" WHERE email = '$email' AND password='$password'";
    $result = pg_query($dbconn, $sql);


    if ($result) {
        // Memeriksa jumlah baris hasil
        $num_rows = pg_num_rows($result);

        if ($num_rows > 0) {

            header("location: dashboard.php");

        } else {
            // Pengguna tidak ditemukan
            echo "Login gagal: Email atau password salah.";
        }
    } else {
        // Kesalahan dalam eksekusi query
        echo "Terjadi kesalahan dalam proses login. Silakan coba lagi.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include "layout/header.html"?>

<div class="container mt-5">
    <h3 class="text-center mb-4">Login</h3>
    <form action="login.php" method="POST" class="mx-auto" style="max-width: 400px;">
        <div class="form-group">
            <input type="email" class="form-control" placeholder="Email" name="email" required/>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Password" name="password" required/>
        </div>
        <button type="submit" name="login" class="btn btn-primary btn-block">Log in</button>
    </form>
</div>

<?php include "layout/footer.html"?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
