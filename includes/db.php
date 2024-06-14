<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jewedding";

$conn = new mysqli($servername, $username, $password, $dbname);

// Error Catching
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
