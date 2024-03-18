<?php
session_start();
include 'koneksi.php';
require_once("helper_auth.php");
redirectIfNotLoggedIn();

if (isset($_SESSION['success'])) {
  ?>
  <audio id="alertSound" src="./template2/dist/img/ambil.mp3" type="audio/mpeg"></audio>
  <?php
  $success = $_SESSION['success'];
  echo "<script>document.addEventListener('DOMContentLoaded', function() {{$success}});</script>";
  unset($_SESSION['success']);
} else if (isset($_SESSION['successClose'])) {
  ?>
  <audio id="alertSound" src="./template2/dist/img/kembali.mp3" type="audio/mpeg"></audio>
  <?php
  $successClose = $_SESSION['successClose'];
  echo "<script>document.addEventListener('DOMContentLoaded', function() {{$successClose}});</script>";
  unset($_SESSION['successClose']);
} else if (isset($_SESSION['error'])) {
  ?>
  <audio id="alertSound" src="./template2/dist/img/error.mp3" type="audio/mpeg"></audio>
  <?php
  $error = $_SESSION['error'];
  echo "<script>document.addEventListener('DOMContentLoaded', function() {{$error}});</script>";
  unset($_SESSION['error']);
}
      if(isset($_POST["submit"])){
        $code_booking = $_POST['booking_number'];

        if ($mysqli->connect_errno) {
          echo "Gagal melakukan koneksi ke MySQL: " . $mysqli->connect_error;
          exit();
        }
                             

        $sql = "SELECT equipment_id, equipment_type, to_timestamp, fullname, booking_number, status  FROM `bookings` WHERE booking_number ='$code_booking'";
        $result = mysqli_query($mysqli,$sql);
        if($result->num_rows > 0){
          while($row = mysqli_fetch_assoc($result)) {
            if($row['status'] == 'Booking'){
              $update = "UPDATE `itjobs`.`bookings` SET `status`='Pinjam' WHERE  `booking_number`= '$code_booking'";
              $resultUpdate = mysqli_query($mysqli,$update);
              if($resultUpdate){
                $SucMessage = "Booking dengan Nomer : ". $row["booking_number"]. " telah di Verifikasi! ,silahkan ambil perangkat yang anda booking. ";
                $script = "
                document.addEventListener('DOMContentLoaded', function() {
                  swal.fire({
                    icon: 'success',
                    title: 'hello ".$row['fullname']."',
                    text: '{$SucMessage}'  
                })    
                });
                ";
                echo "<script>{$script}</script>";
              }
            }else{
                // get data bookings by name and from_timestamp to insert on table history
                $status = "Close";
                date_default_timezone_set('Asia/Jakarta');
                $date = date('Y/m/d H:i:s');  
                  $sqlGet = "SELECT equipment_id, equipment_type, from_timestamp, to_timestamp, booking_time, qty, fullname, booking_number, date  FROM `bookings` WHERE booking_number ='$code_booking'";
                  $result = mysqli_query($mysqli,$sqlGet);
                    $resultGet = mysqli_fetch_all($result, MYSQLI_ASSOC);
                   // $resultGet = mysqli_fetch_assoc($result);
                    foreach($resultGet as $data){
                        $sqlHistory = "INSERT INTO history (equipment_id, equipment_type, from_timestamp, to_timestamp, booking_time, qty, fullname, booking_number, `date`, date_actual_close,  status )
                        VALUES ('".$data['equipment_id']."','".$data['equipment_type']."', '".$data['from_timestamp']."', '".$data['to_timestamp']."', '".$data['booking_time']."',
                        '".$data['qty']."', '".$data['fullname']."', '".$data['booking_number']."', '".$data['date']."', '$date', '$status')";
                        $resultHistory = mysqli_query($mysqli,$sqlHistory);
                        if($resultHistory){
                            $sqlRemove = " DELETE FROM `itjobs`.`bookings` WHERE  `booking_number`= '$code_booking'";
                            $resultMove = mysqli_query($mysqli,$sqlRemove);
                                if($resultMove){
                                  $SucMessage = "peminjaman anda telah selesai, Mohon untuk mengembalikan barang seperti semula!";
                                  $script = "
                                  document.addEventListener('DOMContentLoaded', function() {
                                    swal.fire({
                                      icon: 'success',
                                      title: 'hello ".$data['fullname']."',
                                      text: '{$SucMessage}'  
                                  })                                       
                                  });
                                  ";
                                  echo "<script>{$script}</script>";
                                }

                        }else{
                            echo "test: gagal";
                        }
                    }  
            }
  
          }
        }else {
          $errorMessage = "Input nomer booking anda dengan valid!";
          $script = "
          document.addEventListener('DOMContentLoaded', function() {
            swal.fire({
              icon: 'error',
              title: 'hello',
              text: '{$errorMessage}'  
          })   
          });
          ";
          echo "<script>{$script}</script>";
        }

      }

                                    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Tools</title>
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
<style>
            body {
            padding-top: 40px;
            padding-bottom: 40px;
            /* background:
            linear-gradient(135deg, #ADD8E6 21px, #d9ecff 22px, #d9ecff 24px, transparent 24px, transparent 67px, #d9ecff 67px, #d9ecff 69px, transparent 69px),
            linear-gradient(225deg, #ADD8E6 21px, #d9ecff 22px, #d9ecff 24px, transparent 24px, transparent 67px, #d9ecff 67px, #d9ecff 69px, transparent 69px)0 64px;
            background-color:#ADD8E6;
            background-size: 64px 128px; */
            /* background-color: #006666; */
            /* background-image: url(logo/background.jpg); */
        }
        h4{
            -webkit-text-stroke-width: 1px; 
            -webkit-text-stroke-color: black; 
        }

</style>
<body>
<div class="container-fluid">
        <div class="d-flex justify-content-end pr-4">
          <a id="register" name="register"   href="?register=true">
              Belum punya akun ?
                </a>
                <?php
                if(isset($_GET['register'])) {
                    session_destroy();
                    unset($_SESSION['fullname']);
                    header('location: ./register.php');
                    exit(); 
                }
                ?>
        </div>


    <form class="form col-12 sm-6" method="post" role="form">
            <div class="card-header" style="margin-top:15vh;"> 
            <h4 class="text-warning text-center" style="font-size:90px; ">TAKE OUT / RETURN</h4> 
                <div class="d-flex justify-content-between ">
                  <div class="" style="width:90%;">
                    <input type="text" id="booking_number" name="booking_number" class="form-control my-2 border border-primary p-3" style="text-align:center; font-size:70px;"  placeholder="INPUT CODE BOOKING">
                  </div>
                  <div class="mt-2 text-center" style="width:9%;">
                    <a href="./scan.php" class="card border border-primary p-2 ml-1" style="border-radius:30px;">
                     <img src="./template2/dist/img/barcode-scan.png" alt="">
                    </a> 
                  </div>
                  </div>
                    <div  class="d-flex justify-content-start" style="width:100%;">
                        <button type="submit" name="submit" class="text-light btn btn-warning form-control p-4" style=" border-radius:20px;" ><h3>SUBMIT</h3></button>
                    </div>               
            </div>
    </form>
</div>

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
<script>

function playAlertSound() {
        var alertSound = document.getElementById("alertSound");
        alertSound.play();
    }

 </script>
</body>
</html>