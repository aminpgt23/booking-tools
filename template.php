
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Booking</title>
    <link rel="stylesheet" href="./template2/dist/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./template2/dist/modules/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="./template2/dist/modules/fontawesome/web-fonts-with-css/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="./template2/dist/modules/toastr/build/toastr.min.css">
    <link rel="stylesheet" href="./template2/dist/modules/summernote/summernote-lite.css">
    <link rel="stylesheet" href="./template2/dist/modules/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="./template2/dist/css/demo.css">
    <link rel="stylesheet" href="./template2/dist/css/style.css">
    <link rel="stylesheet" type="text/css" href="./template2/dist/css/calendar.css">
    <link rel="stylesheet" href="./template2/dist/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="./template2/dist/node/flatpickr.min.css">
    <!-- <link rel="website icon" type="png" href="./template2/dist/img/login.png"> -->
</head>
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        tr, th{
            /* border: 1px solid #ddd; */
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #483D8B;
            color: white;
            overflow:hidden;
            
        }
        tr{
          border: 1px solid #ddd;
          border-collapse: collapse;
        }
    </style>
<body>
  <?php
  session_start();
  require_once("./helper_auth.php");
  redirectIfNotLoggedIn();
  include "./koneksi.php";
  if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    $script = "
    document.addEventListener('DOMContentLoaded', function() {
      Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: '{$success}',
        showConfirmButton: false,
        timer: 1000
      }); 
    });
    ";
    echo "<script>{$script}</script>";
    unset($_SESSION['success']);
}
 ?>
  <div class="navbar-bg bg-warning">
    </div>
    
    <nav class="navbar-expand-lg main-navbar d-flex justify-content-end mr-4 " style="margin-top:-6px;">
          <ul class="navbar-nav navbar-right ">
            <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg text-light">
            <i class="ion-android-person"></i>
              <div class="d-sm-none d-lg-inline-block text-light"><?php echo $_SESSION['fullname']?></div></a>
              <div class="dropdown-menu dropdown-menu-right">
                <a href="./booking.php" class="dropdown-item has-icon">
                  <i class="fas fa-book"></i> Booking
                </a>
                <a href="./Check.php" class="dropdown-item has-icon">
                  <i class="fas fa-check"></i> Verifikasi
                </a>
                <a id="logout" name="logout" class="dropdown-item has-icon" href="?logout=true">
                  <i class="ion ion-log-out"></i> Logout
                </a>
                <?php
                if(isset($_GET['logout'])) {
                    session_destroy();
                    unset($_SESSION['fullname']);
                    header('location: ./');
                    exit(); 
                }
                ?>
              </div>
            </li>
          </ul>
        </nav>
  <div class="d-flex ">
      <h1 class="card  p-4 ml-2 mr-2"  style="margin-top:-8px; border-radius:55px;" >
            <div class="d-flex align-self-center">
              <img src="./template2/dist/img/student.png" alt="logo" class="" style="width:70px; height:70px; border-radius:10px;">
            </div>
      </h1>
      <div class="container-fluid ">
      <section class="section">
    <div class="container card ">
        <div class="row">
            <h1 class="col-md-6">
                <div class="p-3 d-flex align-self-center">
                    <div class="p-3" style="font-size: 35px; font-family:Arial Rounded MT Bold;">
                        ADMIN DEVICE
                    </div>
                </div>
            </h1>
            <div class="col-md-6">
                <div class="d-flex justify-content-end mt-4 ">
                    <div class="card-header-action m-1">
                        <a href="template.php?page=device" class="btn btn-outline-secondary " style="border-radius: 30px;">
                            Device
                        </a>
                    </div>
                    <div class="card-header-action m-1">
                        <a href="template.php?page=antrian" class="btn btn-outline-secondary " style="border-radius: 30px;">
                            Antrian Booking
                        </a>
                    </div>
                    <div class="card-header-action m-1">
                        <a href="template.php?page=statistic" class="btn btn-outline-secondary" style="border-radius: 30px;">
                            Statistic Device
                        </a>
                    </div>
                    <div class="card-header-action m-1 mr-5">
                        <a href="template.php?page=history" class="btn btn-outline-secondary" style="border-radius: 30px;">
                            History Booking
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
  </div>
  </div>

  <div class="content">
    <?php

    $page = isset($_GET['page']) ? $_GET['page'] : 'antrian';
    switch ($page) {
        case 'antrian':
            include './admin/antrian.php';
            break;
        case 'device':
            include './admin/device.php';
            break;
        case 'statistic':
            include './admin/statistic.php';
            break;
        case 'history':
            include './admin/history.php';
            break;  
        case 'tambah':
            include './admin/tambah_device.php';
            break;  
        case 'device/edit_device':
            include './admin/edit_device.php';
            break;
        case 'antrian/edit_antrian':
            include './admin/edit_antrian.php';
            break;
        case 'device/delete':
            include './admin/delete_device.php';
            break; 
         case 'antrian/delete':
            include './admin/delete_antrian.php';
            break;                                   
        default:
            include './admin/antrian.php';
            break;
    }
    ?>
</div>

<script src="./template2/dist/node/flatpickr.min.js"></script>
  <script src="./template2/dist/modules/jquery.min.js"></script>
  <script src="./template2/dist/modules/toastr/build/toastr.min.js"></script>
  <script src="./template2/dist/modules/popper.js"></script>
  <script src="./template2/dist/modules/tooltip.js"></script>
  <script src="./template2/dist/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="./template2/dist/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="./template2/dist/modules/scroll-up-bar/dist/scroll-up-bar.min.js"></script>
  <script src="./template2/dist/js/sa-functions.js"></script>
  <script src="./template2/dist/modules/chart.min.js"></script>
  <script src="./template2/dist/js/custom.js"></script>
  <script src="./template2/dist/modules/summernote/summernote-lite.js"></script>
  <script src="./template2/dist/dist/sweetalert2.min.js"></script>
  <!-- <script src="./AJAX/jquery.js"></script> -->
  <script>


$(".alert-message").alert().delay(1000).slideUp('slow');

function updateDeviceData() {
    $.ajax({
        url: './Data/data_device.php', 
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            $('#tableDevice').html(response.data);
        },
        error: function(error) {
            console.error('Error fetching data:', error);
        }
    });
}

function updateBookingData() {
    $.ajax({
        url: './Data/data_antrian.php', 
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            $('#bookingTableBody').html(response.html);
        },
        error: function(error) {
            console.error('Error fetching data:', error);
        }
    });
}

updateBookingData();
updateDeviceData();
setInterval(function() {
updateBookingData();
updateDeviceData();
}, 3000);

</script>
</body>
</html>
