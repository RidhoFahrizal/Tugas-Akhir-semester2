<?php
include "Service/database.php";

$sql = "SELECT * FROM public.\"users\"";
$row = pg_fetch_assoc(pg_query($dbconn,$sql));
$userID = $row['id'];

// Simpan ID pengguna ke dalam session
$_SESSION['userID'] = $userID;

echo "ID terakhir yang dimasukkan adalah: $userID";