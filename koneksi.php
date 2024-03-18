<?php




//koneksi server devtbr
// $host    = "10.129.78.199";
// $user    = "devtbr";
// $pass    = "devtbr";
// $db      = "itjobs";
// $port = 6446;

// $mysqli = new mysqli($host, $user, $pass, $db, $port);


// // Periksa apakah koneksi berhasil
// if ($mysqli->connect_errno) {
//     echo "Gagal melakukan koneksi ke MySQL: " . $mysqli->connect_error;
//     exit();
// }

// koneksi local

$host    = "localhost";
$user    = "root";
$pass    = "";
$db        = "itjobs";
    $mysqli = new mysqli($host, $user, $pass, $db);
// Periksa apakah koneksi berhasil
if ($mysqli->connect_errno) {
    echo "Gagal melakukan koneksi ke MySQL: " . $mysqli->connect_error;
    exit();
}

