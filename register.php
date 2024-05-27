<?php
session_start();
global $dbconn, $dbname;
include "Service/database.php";

if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "INSERT INTO public.\"users\" (email, password) VALUES ('$email', '$password') RETURNING id";
    $result = pg_query($dbconn, $sql); // Eksekusi query

    if ($result) {
        echo "Data berhasil dimasukkan ke dalam database.";

        // Ambil ID terakhir dari hasil query
        $row = pg_fetch_assoc($result);
        $userID = $row['id'];

        // Simpan ID pengguna ke dalam session
        $_SESSION['userID'] = $userID;
        echo "ID terakhir yang dimasukkan adalah: $userID";
    } else {
        echo "Gagal memasukkan data ke dalam database.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include "layout/header.html"?>

<div class="container mt-5">
    <h3 class="text-center mb-4">DAFTAR AKUN</h3>
    <form action="register.php" method="POST" class="mx-auto" style="max-width: 400px;">
        <div class="form-group">
            <input type="email" class="form-control" placeholder="Email" name="email" required />
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Password" name="password" required />
        </div>
        <button type="submit" name="register" class="btn btn-primary btn-block">Register Now</button>
    </form>
</div>

<?php include "layout/footer.html"?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
