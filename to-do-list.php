<?php
session_start();
include "layout/navbar-dashboard.php";
include "Service/database.php";

if (!isset($_SESSION['userID'])) {
    // Jika tidak ada sesi, arahkan ke halaman login
    //header('Location: login.php');
    echo " sesi gagal";
    exit();
}

