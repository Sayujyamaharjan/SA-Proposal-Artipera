<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "Artipera";
$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Database connection error ..." . mysqli_connect_error());
}
