<?php
session_start();
include "Service/database.php";

if (isset($_POST['submit'])) {
    // Ambil data dari form
    $username = pg_escape_string($dbconn, $_POST["username"]);
    $birth_date = pg_escape_string($dbconn, $_POST["birth_date"]);
    $gender = pg_escape_string($dbconn, $_POST["gender"]);
    $address = pg_escape_string($dbconn, $_POST["address"]);

    // Query untuk menyisipkan data ke dalam tabel users
    $query = "INSERT INTO users (username, birth_date, gender, address) 
              VALUES ('$username', '$birth_date', '$gender', '$address')";

    // Eksekusi query
    $result = pg_query($dbconn, $query);
    if (!$result) {
        echo "Gagal menyisipkan data: " . pg_last_error($dbconn) . "<br>";
    } else {
        echo "Data berhasil disisipkan.";
    }

    // Tutup koneksi
    pg_close($dbconn);
}
?>


<!DOCTYPE html>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Data Diri</title>
</head>
<body>
<h2>Formulir Data Diri</h2>
<form action="data-diri.php" method="POST">

    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username" required><br><br>

    <label for="birth_date">Tanggal Lahir:</label><br>
    <input type="date" id="birth_date" name="birth_date" required><br><br>

    <label for="gender">Jenis Kelamin:</label><br>
    <input type="radio" id="pria" name="gender" value="Pria" required>
    <label for="pria">Pria</label>
    <input type="radio" id="wanita" name="gender" value="Wanita" required>
    <label for="wanita">Wanita</label><br><br>

    <label for="address">Alamat:</label><br>
    <textarea id="address" name="address" rows="4" cols="50" required></textarea><br><br>

    <input type="submit" name="submit" value="Submit">
</form>
</body>
</html>

