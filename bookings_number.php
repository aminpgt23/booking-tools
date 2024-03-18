
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>kode bokings</title>
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
    <script src="./template2/dist/node/qrcode.min.js"></script>
</head>
<style>
    body{
        margin-top:6vh;
    }
</style>
<body>
            <div class="text-left ml-4">
                <a href="./booking.php" class="text-center"> &#10094; KEMBALI</a>
            </div>
            <div class="float-right mr-4">
            <a id="scan" name="scan" class="dropdown-item has-icon" href="?scan=true" >
                        <i class="ion ion-log-out"></i> scan
                        </a>
                        <?php
                        session_start();
                        if(isset($_GET['scan'])) {
                       header("Location: ./Check.php");
                }
                ?>
    </div>
<?php
// session_start();
require_once("helper_auth.php");
redirectIfNotLoggedIn();
include "koneksi.php"; 

$SQLSesion = "SELECT equipment_id, equipment_type, from_timestamp, to_timestamp, booking_time, qty, fullname, booking_number, `date`, status FROM bookings WHERE fullname = '".$_SESSION['fullname']."'";  
$result = mysqli_query($mysqli, $SQLSesion);
if ($result) {
    $availabilitySession = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if (empty($availabilitySession)) {
        ?>
        <div class="container text-center"><p>BOOKING DATA NOT AVAILABLE</p></div>
        <!-- <div class="container d-flex justify-content-center">

                <a href="./booking.php" class="text-center">KEMBALI</a>
        </div> -->
        <?php
    } 
    else {
        foreach ($availabilitySession as $index => $data) { ?>
            <div class="container-fluid d-flex justify-content-center">
                <div class="card-header" style="width:50vh; height:110vh; border:black 1px solid;">
                    <div class="d-flex flex-column justify-content-center">
                        <div class="column text-center">
                            <i class="ion-checkmark-circled text-success p-2" style="font-size: 50px;"></i>
        
                            <div class="form-group">
                                <label for="" class="text-center">Nama Lengkap</label>
                                <h5 class="text-dark"><?php echo $_SESSION['fullname'] ?></h5>
                            </div>
                            <div class="form-group">
                                <label for="" class="text-center">Nama Perangkat</label>
                                <h5 class="text-dark" name="equipment_id"><?php echo $data['equipment_type']; ?></h5>
                                <a>ID : <?php echo $data['equipment_id']; ?></a>
                            </div>
                            <div class="form-group">
                                <label for="" class="text-center">Number Booking</label>
                                <h5 class="text-dark" name="booking_number"><?php echo $data['booking_number'] ?></h5>
                                <div id="qrcode_<?php echo $index ?>" class="d-flex justify-content-center"></div>
                            </div>
                            <script>
                                var qrcode_<?php echo $index ?> = new QRCode(document.getElementById("qrcode_<?php echo $index ?>"), {
                                    text: "<?php echo $data['booking_number'] ?>",
                                    width: 128,
                                    height: 128,
                                    colorDark: "#000000",
                                    colorLight: "transparent",
                                    correctLevel: QRCode.CorrectLevel.H
                                });
                            </script>
                            <div class="form-group">
                                <label for="" class="text-center">Tanggal Booking</label>
                                <p class="text-dark" name="booking_number"><?php echo $data['date'] ?></p>
                            </div>
                            <div class="form-group">
                                <label for="" class="text-center">Ambil Device</label>
                                <p class="text-dark" name="booking_number"><?php echo $data['from_timestamp'] ?></p>
                            </div>
                            <div class="form-group">
                                <label for="" class="text-center">Device Di kembalikan pada:</label>
                                <p class="text-dark" name="booking_number"><?php echo $data['to_timestamp'] ?></p>
                            </div>
        
                            <div class="form-group">
                                <label for="" class="text-center">Status</label>
                                <p class="text-dark" name="booking_number"><?php echo $data['status'] ?></p>
                                <?php
                                if ($data['status'] == 'Booking') {
                                    ?>
                                    <form action="" method="post" role="form">
                                        <input type="hidden" name="bookings_number" id="bookingsnumber" value="<?php echo $data['booking_number'] ?>">
                                        <button class="submit bg-danger" id="submit" type="submit" name="submit">
                                            Cancel
                                        </button>
                                        <?php
                                        //session_start();
                                        include 'koneksi.php';
                                        if (isset($_POST["submit"])) {
                                            include 'koneksi.php';
                                            $code_booking = isset($_POST['bookings_number']) ? $_POST['bookings_number'] : '';
        
                                            if ($mysqli->connect_errno) {
                                                echo "Gagal melakukan koneksi ke MySQL: " . $mysqli->connect_error;
                                                exit();
                                            }
        
                                            $status = "Cancel";
                                            date_default_timezone_set('Asia/Jakarta');
                                            $date = date('Y/m/d H:i:s');
        
                                            // Insert into history
                                            $sqlHistory = "INSERT INTO history (equipment_id, equipment_type, from_timestamp, to_timestamp, booking_time, qty, fullname, booking_number, `date`, date_actual_close,  status )
                                                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
                                            $stmtHistory = $mysqli->prepare($sqlHistory);
                                            $stmtHistory->bind_param("sssssssssss", $data['equipment_id'], $data['equipment_type'], $data['from_timestamp'], $data['to_timestamp'], $data['booking_time'],
                                                $data['qty'], $data['fullname'], $data['booking_number'], $data['date'], $date, $status);
        
                                            $resultHistory = $stmtHistory->execute();
        
                                            if ($resultHistory) {
                                                // Delete from bookings
                                                $sqlRemove = "DELETE FROM `itjobs`.`bookings` WHERE `booking_number` = ?";
                                                $stmtRemove = $mysqli->prepare($sqlRemove);
                                                $stmtRemove->bind_param("s", $code_booking);
        
                                                $resultMove = $stmtRemove->execute();
        
                                                if ($resultMove) {
                                                    $SucMessage = "Booking anda telah di Cancel,";
                                                    $script = "
                                                                document.addEventListener('DOMContentLoaded', function () {
                                                                    Swal.fire({
                                                                        icon: 'success',
                                                                        title: 'hello " . $_SESSION['fullname'] . "',
                                                                        text: ' {$SucMessage}'
                                                                    }).then(function () {
                                                                        window.location.href = './bookings_number.php';
                                                                    });
                                                                });
                                                                ";
                                                    echo "<script>{$script}</script>";
                                                } else {
                                                    echo "Gagal menghapus data dari tabel bookings: " . $stmtRemove->error;
                                                }
        
                                                $stmtRemove->close();
                                            } else {
                                                echo "Gagal memindahkan data ke tabel history: " . $stmtHistory->error;
                                            }
        
                                            $stmtHistory->close();
                                        }
                                        ?>
                                    </form>
                                <?php
                                }
                                ?>
        
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
    }
} else {
    echo "data no exists!";
}
?> 
    
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
</body>
</html>