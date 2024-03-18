<?php


// Fungsi untuk memeriksa apakah pengguna sudah login
function isUserLoggedIn() {
    return isset($_SESSION['fullname']);
    if($_SESSION['admin'] == 1){
        header("Location: ../admin/antrian.php");
    }else{
        header("Location: ./booking.php");
    }
}

// Fungsi untuk me-redirect pengguna jika belum login
function redirectIfNotLoggedIn() {
    if (!isUserLoggedIn()) {
        header("Location: ./login.php"); // Ganti login.php dengan halaman login Anda
        exit();
    }
}
?>
