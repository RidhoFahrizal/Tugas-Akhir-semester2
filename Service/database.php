<?php
$host = "localhost";
$port = "5432";
$dbname = "users";
$user = "postgres";
$password = "ridho101005";
$connection_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password}";
$dbconn = pg_connect($connection_string);

if (!$dbconn){
    echo "Error Connection";
    die("Error!");
}