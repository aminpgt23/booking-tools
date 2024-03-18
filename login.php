<?php
        session_start();
        include "koneksi.php";
        if (isset($_POST['submit'])) {
            $nip = $_POST['nip'];
            $password = $_POST['pass'];

            if ($mysqli->connect_errno) {
                echo "Gagal melakukan koneksi ke MySQL: " . $mysqli->connect_error;
                exit();
            }

            // Kueri untuk mengambil data user berdasarkan nip
            $stmt = $mysqli->prepare("SELECT `name`, `admin`, fullname, pass FROM loggin WHERE nip = ?");
            $stmt->bind_param("s", $nip);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($nip, $admin, $fullname, $dbPassword);
                $stmt->fetch();
                // Membandingkan kata sandi yang diinputkan dengan yang ada di database
                if ($password === $dbPassword) {
                    // Kata sandi cocok, izinkan akses
                    // Simpan nilai kedalam sesi
                    $_SESSION['nip'] = $nip;
                    $_SESSION['admin'] = $admin;
                    $_SESSION['fullname'] = $fullname;
                    $_SESSION['password'] = $dbPassword;
                    // Redirect ke halaman joblist.php
                    if($admin == "1"){
                        $_SESSION['success'] = '<p>Selamat datang Kembali.!</p>';
                        // header("Location: ./admin/dashboard_booking.php");
                        header("Location: ./template.php");
                    }else{
                        $_SESSION['success'] = '<p>Selamat datang Kembali.!</p>';
                        header("Location: ./booking.php");
                    }
                    exit();
                } else {
                    // Jika kata sandi tidak cocok, berikan pesan kesalahan
                    $_SESSION['err'] = '<strong>ERROR!</strong> Kata Sandi Salah.';
                    header("Location: ./login.php");
                    exit();
                }
                
            } else {
                // Jika data tidak ditemukan, berikan pesan kesalahan
                $_SESSION['err'] = '<strong>ERROR!</strong> Username Atau Sandi Salah.';
                header("Location: ./login.php");
                exit();
            }

            // Tutup pernyataan
            $stmt->close();
            $mysqli->close();
        } else {
            // Kode jika $_POST['submit'] belum diatur

        }
        ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> -->
    <!-- <link href="/GitHub/node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="./template2/dist/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./template2/dist/modules/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="./template2/dist/modules/fontawesome/web-fonts-with-css/css/fontawesome-all.min.css">

    <link rel="stylesheet" href="./template2/dist/modules/summernote/summernote-lite.css">
    <link rel="stylesheet" href="./template2/dist/modules/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="./template2/dist/css/demo.css">
    <link rel="stylesheet" href="./template2/dist/css/style.css">
    <title>Booking</title>
    <link rel="website icon" type="png" href="./template2/dist/img/login.png">
    <style type="text/css">
        body {
            padding-top: 15vh;
            /* background:
            linear-gradient(135deg, #ADD8E6 21px, #d9ecff 22px, #d9ecff 24px, transparent 24px, transparent 67px, #d9ecff 67px, #d9ecff 69px, transparent 69px),
            linear-gradient(225deg, #ADD8E6 21px, #d9ecff 22px, #d9ecff 24px, transparent 24px, transparent 67px, #d9ecff 67px, #d9ecff 69px, transparent 69px)0 64px;
            background-color:#ADD8E6;
            background-size: 64px 128px; */
        }

        .form-control {
            border-radius: 5px;
        }

        .form-signin {
            padding: 10px;
            margin: 0 auto;
            /* color: #006666; */
            margin-top: 5%;
            margin-bottom:5%;
            /* box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px; */
            border-radius: 10px;
            padding-left: 3%;
            padding-right: 3%;
            zoom: 100%;
            width: 350px;
            /* width: 360px; */
            height: auto;
        }

        .form-signin .form-signin-heading,
        .form-signin .checkbox {
            margin-bottom: 10px;
            text-align: center;
        }

        .form-signin .checkbox {
            font-weight: normal;
        }

        .form-signin .form-control {
            position: relative;
            height: auto;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            padding: 10px;
            font-size: 16px;
        }

        .form-signin .form-control:focus {
            z-index: 2;
        }

        .form-signin input[type="text"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

        h2 {
            --font-google: var(--font-gsans), sans-serif;
            color: blue;

        }

        .btn-primary {
            color: #ffffff;
            /* border-color: #2780e3; */
            border-radius: 7px;
        }

        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary.focus,
        .btn-primary:active,
        .btn-primary.active,
        .open>.dropdown-toggle.btn-primary {
            color: #ffffff;
            background-color: blue;
            /* border-color: #1862b5; */
            font-weight: bold;
            animation-delay: 0.5s;
            font-size: x-large;
            transition: 0.2s;
        }

        .btn-primary::after {
            animation-delay: 1.2s;
            font-size: large;
            transition: 0.5s;
        }

        .icon-bar {
            color: #000000
        }
        h2{
            -webkit-text-stroke-width: 1px; 
            -webkit-text-stroke-color: black; 
          
        }
    </style>

</head>

<body>
    <div class="container">
       
            <div class="card-header" style="">
                <form class="form-signin" method="post" action="" role="form">
                    <?php
                        //  include 'register.php';
                    if (isset($_SESSION['err'])) {
                        $err = $_SESSION['err'];
                        echo '<div class="alert alert-warning alert-message">' . $err . '</div>';
                        // Setelah menampilkan pesan error, hapus session['err'] agar tidak ditampilkan lagi
                        unset($_SESSION['err']);
                    } else if (isset($_SESSION['success'])) {
                        $success = $_SESSION['success'];
                        echo '<div class="alert alert-success alert-message">' . $success . '</div>';
                        // Setelah menampilkan pesan error, hapus session['err'] agar tidak ditampilkan lagi
                        unset($_SESSION['success']);
                    }
                    ?>
                    <h2 class="form-signin-heading text-warning" style="font-size: 60px;"><strong>LOGIN</strong></h2>
                    <input type="text" name="nip" class="form-control border border-secondary" placeholder="NIP" required autofocus>
                    <br>
                    <input type="password" name="pass" class="form-control border border-secondary" placeholder="Kata Sandi" required>
                    <button class="btn btn-lg btn-warning btn-block" type="submit" name="submit">submit</button>
                    <p>&nbsp;</p>
                    <p class="text-center">dont have an acount ? <a href="./register.php">register</a></p>
                </form>
            </div>
      
    </div>



    <!-- Bootstrap core JavaScript, Placed at the end of the document so the pages load faster -->
  <script src="./template2/dist/modules/jquery.min.js"></script>
  <script src="./template2/dist/modules/popper.js"></script>
  <script src="./template2/dist/modules/tooltip.js"></script>
  <script src="./template2/dist/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="./template2/dist/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="./template2/dist/modules/scroll-up-bar/dist/scroll-up-bar.min.js"></script>
  <script src="./template2/dist/js/sa-functions.js"></script>
  <script src="./template2/dist/modules/chart.min.js"></script>
  <script src="./template2/dist/modules/summernote/summernote-lite.js"></script>
  <script src="./template2/dist/dist/sweetalert2.min.js"></script>
    <script type="text/javascript">
        $(".alert-message").alert().delay(3000).slideUp('slow');
    </script>
</body>

</html>