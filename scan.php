<?php
include "koneksi.php";
         if(isset($_POST["hasilscan"])){
            $code_booking = $_POST['hasilscan'];
    
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
                      session_start();
                      $SucMessage = "Booking dengan Nomer : ". $row["booking_number"]. " telah di Verifikasi! ,silahkan ambil perangkat yang anda booking. ";
                      $_SESSION['success'] = "swal.fire({
                                              icon: 'success',
                                              title: 'Hello',
                                              text: '{$SucMessage}'  
                                          }); playAlertSound();";
                      header("location: ./Check.php");
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
                                      session_start();
                                      $SucMessage = "peminjaman anda telah selesai, Mohon untuk mengembalikan barang seperti semula!";
                                      $_SESSION['successClose'] = "swal.fire({
                                                              icon: 'success',
                                                              title: 'Hello',
                                                              text: '{$SucMessage}'  
                                                          }); playAlertSound();";
                                      header("location: ./Check.php");
                                    }  
                            }else{
                                echo "test: gagal";
                            }
                        }  
                }
      
              }
            }else {
                session_start();
                $errorMessage = "Input nomer booking anda dengan valid!";
                $_SESSION['error'] = "swal.fire({
                                        icon: 'error',
                                        title: 'Hello',
                                        text: '{$errorMessage}'  
                                    }); playAlertSound();";
                header("location: ./Check.php");              
            }   
          }
         ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCAN</title>
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



    /* Animasi */
    @keyframes scanAnimation {
        0% { top: 0; }
        100% { top: 100%; }
    }

    .scan-line {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 2px; /* Sesuaikan ketebalan garis pemindaian */
        background-color: yellow; /* Sesuaikan warna garis pemindaian */
        animation: scanAnimation 2s infinite; /* Sesuaikan kecepatan dan durasi pemindaian */
    }
</style>
<body class="bg-warning">
<div class="text-center mt-5 text-light">
    <h2> SCAN QR-CODE DEVICE</h2>
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
 </div>
        <div class="d-flex justify-content-center mt-3" style="height:560px; width:100%;">
            <div class="card p-2">
            <video id="preview" style="height:510px; width:100%;" playsinline autoplay ></video>
            <div class="scan-line"></div>
            </div>    
            <form action="" method="post">
                <input type="hidden" id="hasilscan" name="hasilscan" value="">      
            </form>
        </div>
    <script src="./template2/dist/node/js/instascan.min.js"></script>
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
    Instascan = window.Instascan;
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });

    // Fungsi untuk memulai pemindaian dengan kamera yang dipilih
    function startScanningWithCamera(camera) {
        scanner.start(camera);
    }

    // Fungsi untuk menampilkan pesan kesalahan jika tidak ada kamera yang tersedia
    function handleNoCameras() {
        console.error('No cameras found.');
    }

    // Mendapatkan daftar kamera yang tersedia
    Instascan.Camera.getCameras()
        .then(function (cameras) {
            if (cameras.length > 0) {
                // Memilih kamera pertama yang tersedia untuk memulai pemindaian
                startScanningWithCamera(cameras[0]);
            } else {
                handleNoCameras();
            }
        })
        .catch(function (e) {
            console.error(e);
        });

    // Menambahkan listener untuk pemindaian
    scanner.addListener('scan', function (content) {
        document.getElementById('hasilscan').value = content;
        document.querySelector('form').submit();
    });
</script>


</div>
</body>
</html>

