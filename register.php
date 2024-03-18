<?php
    session_start();
if($_SERVER['REQUEST_METHOD']=='POST'){
    include 'koneksi.php';
    $nip = $_POST['nip'];
    $name = $_POST['name'];
    $fulname = $_POST['fullname'];
    $password = $_POST['pass'];

    if ($mysqli->connect_errno) {
        echo "Gagal melakukan koneksi ke MySQL: " . $mysqli->connect_error;
        exit();
    };
   // $sql = "insert into `loggin` (nip,name,pass,fullname) values ('$nip','$name','$password','$fulname')";
    $checkQuery = "SELECT * FROM `loggin` WHERE nip = '$nip'";
    $checkResult = mysqli_query($mysqli, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        $_SESSION['err'] = '<strong>ERROR!</strong> NIP sudah di gunakan.';
        header("Location: ./register.php"); 
        exit();
        } else {
            // NIP doesn't exist, proceed with insertion
            $sql = "INSERT INTO `loggin` (nip, name, pass, fullname) VALUES ('$nip', '$name', '$password', '$fulname')";
            $result = mysqli_query($mysqli, $sql);

            if ($result) {
                $_SESSION['success'] = '<strong>SUCCESS!</strong> register successfully!';
                header("Location: ./login.php"); 
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Error inserting data.'
                ];
            }
        }
    echo json_encode($response);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register Bookings</title>
    <link rel="website icon" type="png" href="./template2/dist/img/mastercard.png">
    <link rel="stylesheet" href="./template2/dist/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./template2/dist/modules/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="./template2/dist/modules/fontawesome/web-fonts-with-css/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="./template2/dist/modules/toastr/build/toastr.min.css">
    <link rel="stylesheet" href="./template2/dist/modules/summernote/summernote-lite.css">
    <link rel="stylesheet" href="./template2/dist/modules/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="./template2/dist/css/demo.css">
    <link rel="stylesheet" href="./template2/dist/css/style.css">
    <link rel="stylesheet" href="./template2/dist/dist/sweetalert2.min.css">
    <link rel="website icon" type="png" href="./template2/dist/img/login.png">
</head>
    <style type="text/css">
        body {
            padding-top: 10vh;
            /* background:
            linear-gradient(135deg, #ADD8E6 21px, #d9ecff 22px, #d9ecff 24px, transparent 24px, transparent 67px, #d9ecff 67px, #d9ecff 69px, transparent 69px),
            linear-gradient(225deg, #ADD8E6 21px, #d9ecff 22px, #d9ecff 24px, transparent 24px, transparent 67px, #d9ecff 67px, #d9ecff 69px, transparent 69px)0 64px;
            background-color:#ADD8E6;
            background-size: 64px 128px; */
        }

        .form-control {
            border-radius: 5px;
        }

        .form-signUp {
            padding: 10px;
            margin: 0 auto;
            /* color: #006666; */
            /* margin-top: 5%; */
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

        .form-signUp .form-signUp-heading,
        .form-signUp .checkbox {
            margin-bottom: 10px;
            text-align: center;
        }

        .form-signUp .checkbox {
            font-weight: normal;
        }

        .form-signUp .form-control {
            position: relative;
            height: auto;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            padding: 10px;
            font-size: 16px;
        }

        .form-signUp .form-control:focus {
            z-index: 2;
        }

        .form-signUp input[type="text"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signUp input[type="password"] {
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
<body>
<div class="container">

       <div class="card-header" style="">
           <form class="form-signUp" method="post" action="register.php" role="form">
               <h2 class="form-signUp-heading text-warning" style="font-size: 60px;"><strong>SIGN UP</strong></h2>
               <?php
                    if (isset($_SESSION['err'])) {
                        $err = $_SESSION['err'];
                        echo '<div class="alert alert-warning alert-message">' . $err . '</div>';
                        // Setelah menampilkan pesan error, hapus session['err'] agar tidak ditampilkan lagi
                        unset($_SESSION['err']);
                    }
                    ?>
               <input type="text" name="nip" class="form-control border border-secondary" placeholder="NIP" required autofocus>
               <br>
               <input type="text" name="name" class="form-control border border-secondary" placeholder="nama" required>
               <br>
               <input type="text" name="fullname" class="form-control border border-secondary" placeholder="nama lengkap" required>
               <br>
               <input type="password" name="pass" class="form-control border border-secondary" placeholder="Kata Sandi" required>
               <button class="btn btn-lg btn-warning btn-block" type="submit" name="submit">submit</button>
               <p>&nbsp;</p>
               <p class="text-center">already an acount ? <a href="./login.php">Login</a></p>
           </form>
       </div>
 
</div>

</body>
<script src="./template2/dist/modules/jquery.min.js"></script>
<script src="./template2/dist/modules/popper.js"></script>
<script src="./template2/dist/modules/tooltip.js"></script>
<script src="./template2/dist/modules/toastr/build/toastr.min.js"></script>
<script src="./template2/dist/modules/bootstrap/js/bootstrap.min.js"></script>
<script src="./template2/dist/modules/nicescroll/jquery.nicescroll.min.js"></script>
<script src="./template2/dist/modules/scroll-up-bar/dist/scroll-up-bar.min.js"></script>
<script src="./template2/dist/js/sa-functions.js"></script>
<script src="./template2/dist/modules/chart.min.js"></script>
<script src="./template2/dist/modules/summernote/summernote-lite.js"></script>
<script src="./template2/dist/dist/sweetalert2.min.js"></script>
<script type="text/javascript">
        $(".alert-message").alert().delay(1000).slideUp('slow');
    </script>
</html>