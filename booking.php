<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>booking form</title>
  <link rel="stylesheet" href="./template2/dist/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="./template2/dist/modules/ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="./template2/dist/modules/fontawesome/web-fonts-with-css/css/fontawesome-all.min.css">
  <link rel="stylesheet" href="./template2/dist/modules/toastr/build/toastr.min.css">
  <link rel="stylesheet" href="./template2/dist/modules/summernote/summernote-lite.css">
  <link rel="stylesheet" href="./template2/dist/modules/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="./template2/dist/css/demo.css">
  <link rel="stylesheet" href="./template2/dist/css/style.css">
  <link rel="stylesheet" href="./template2/dist/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="./template2/dist/node/flatpickr.min.css">
  <link rel="website icon" type="png" href="./template2/dist/img/login.png">
</head>
<style>
    body{
        /* background-color:#B0C4DE; */
            /* background:
            linear-gradient(135deg, #ADD8E6 21px, #d9ecff 22px, #d9ecff 24px, transparent 24px, transparent 67px, #d9ecff 67px, #d9ecff 69px, transparent 69px),
            linear-gradient(225deg, #ADD8E6 21px, #d9ecff 22px, #d9ecff 24px, transparent 24px, transparent 67px, #d9ecff 67px, #d9ecff 69px, transparent 69px)0 64px;
            background-color:#ADD8E6;
            background-size: 64px 128px; */
    }
        .item.card:hover {
        transform: scale(1.05);
        transition: transform 0.3s ease;
    }
    /* #bookButton{
        background-color: #ADD8E6;
    } */
    .selected-card {
    background-color: #B0C4DE;
    }

   
</style>
<body >
<?php
    session_start();
    require_once("helper_auth.php");
    redirectIfNotLoggedIn();
        include  "koneksi.php"; 
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
    <div class="body-content">
        <form method="post">
            <div class="tempo">
                <div class="m-3">
                    <section class="section">
                            <div class="card-header mt-4" style="height:300px; border:white 1px solid;">           
                                <div class="d-flex justify-content-between">
                                    <h2 style="font-size:6vh;"><b> BOOKING IT DEVICE</b></h2>
                                    <h5 type="text" class="form control" value="">BOOKING BY : <?php echo $_SESSION['fullname']; ?></h5>
                                </div>                         
                                <div class="d-flex justify-content-between">
                                    <div class="row ml-2">
                                        <a href="./bookings_number.php" name="number" id="number" class="text-secondary mr-2">Detail Bookingan anda?</a>
                                        <div onclick="Note(); return false;" ><i class="fas fa-book p-1">Panduan</i></div>    
                                    </div>
                                    <?php
                                    if($_SESSION['admin'] != null){
                                        ?>
                                        <a href="template.php?page=antrian" name="number" id="number" class="text-secondary">Back?</a>
                                        <?php
                                    }else{
                                        ?>
                                    <a href="?logout=true" name="logout" id="logout" class="text-secondary">Logout?</a>                                  
                                        <?php
                                    }
                                    if(isset($_GET['logout'])) {
                                        session_destroy();
                                        unset($_SESSION['fullname']);
                                        header('location: ./');
                                        exit(); // Add exit to stop further script execution
                                    }
                                    ?>
                                </div>
                                    <div class="d-flex " style="margin-top:30px;">
                                        <div class="form-group col-6" data-target-input="nearest">
                                            <label>FROM</label>
                                            <input type="text" class="form-control border border-secondary p-3  datetimepicker-input" style="border-radius:20px; border: gray 1px solid;" data-target="#fromPicker" id="from" name="from" data-input value="">
                                        </div>
                                        <div class="form-group col-6" data-target-input="nearest">
                                            <label >TO </label>
                                            <input type="text" class="form-control border border-secondary p-3 datetimepicker-input" style="border-radius:20px; border: gray 1px solid;" data-target="#toPicker" id="to" name="to" data-input value="">
                                        </div>
                                    </div>
                                    <div class="form-group" style="width:100%;">
                                        <div class="d-flex justify-content-center" style="margin-top:4px; ">
                                            <button  type="" name="bookButton" id="bookButton" class="btn btn-warning p-3" style="width:100vw; border-radius:20px;  border: white 1px solid;">
                                                <h2>CEK KETERSEDIAAN</h2>
                                            </button>
                                        </div>
                                    </div>
                                   
                            </div>
                        </section>
                        <!-- <div class="form-group">
                        </div> -->
                        <div class="form-group text-center">
                            <!-- <label class="text-dark">#Ketersediaan tools sesuai range tanggal diatas</label> -->
                        </div><br>
                        <div class="card-header" style="margin-top:15px;  height:40vh; border-radius:50px; border:white 1px solid;">   
                        <div class="container">                                        
                            <div class="row justify-content-center" style="margin-top:-4%" >
                                    <?php
                                        include 'koneksi.php';
                                            // Get the "from" and "to" timestamps from the POST data
                                            $from = isset($_POST['from']) ? $_POST['from'] : '';
                                            $to = isset($_POST['to']) ? $_POST['to'] : '';
                                            date_default_timezone_set('Asia/Jakarta');
                                            $datenow = date('Y-m-d H:i:s');                          
                                           // $Laptop = 'Laptop';
                                            if (isset($_POST['bookButton'])) {
                                                if ($from == '' || $to == '' || $from >= $to ) {
                                                    $errorMessage = "Tanggal yang Anda masukkan tidak benar!";
                                                    $script = "
                                                        document.addEventListener('DOMContentLoaded', function() {
                                                            swal.fire({
                                                                icon: 'error',
                                                                title: 'Hello',
                                                                text: '{$errorMessage}'  
                                                            })   
                                                        });
                                                    ";
                                                    echo "<script>{$script}</script>";                                               
                                                }else{  
                                                    $query = "SELECT DISTINCT equipment.equipment_id, equipment.equipment_type, equipment.brand_type
                                                    FROM equipment
                                                    WHERE equipment.equipment_id NOT IN (
                                                        SELECT equipment_id
                                                        FROM bookings
                                                        WHERE ('$from' < to_timestamp AND '$to' > from_timestamp)
                                                            OR ('$from' = to_timestamp AND '$to' = from_timestamp)
                                                            OR ('$from' >= from_timestamp AND '$from' < to_timestamp) 
                                                            OR ('$to' > from_timestamp AND '$to' <= to_timestamp)
                                                    )
                                                    ORDER BY equipment.equipment_id ASC;";                                                 
                                                    // $query = "SELECT DISTINCT equipment.equipment_id, equipment.equipment_type, equipment.brand_type
                                                    // FROM equipment
                                                    // WHERE equipment.equipment_id NOT IN (
                                                    //     SELECT equipment_id
                                                    //     FROM bookings
                                                    //     WHERE ('$from' BETWEEN from_timestamp AND to_timestamp OR '$to' BETWEEN from_timestamp AND to_timestamp)
                                                    //     OR (from_timestamp BETWEEN '$from' AND '$to' OR to_timestamp BETWEEN '$from' AND '$to')
                                                    // )
                                                    // ORDER BY equipment.equipment_id ASC;";                 
                                                    $result = mysqli_query($mysqli, $query);
                                                    if ($result) {
                                                        // Fetch all rows into an associative array
                                                        $availabilityData = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                                        if($availabilityData == null){
                                                            ?>
                                                            <div class="text-center text-primary p-2">laptop atau proyektor sedang kosong</div>
                                                            <?php
                                                        }
                                                        // Loop through the data and display equipment cards
                                                        foreach ($availabilityData as $equipment) {
                                                            ?>                                                        
                                                                <div class="col-lg-3 col-md-6 col-sm-12">
                                                                    <div class="item card card-sm-3" data-equipment-id="<?php echo $equipment['equipment_id']; ?>" style="border: gray 1px solid; width:33vh; border-radius:20px;" onclick="selectEquipment('<?php echo $equipment['equipment_type']; ?>', '<?php echo $equipment['equipment_id']; ?>')">
                                                                        <div class="card-icon bg-secondary">
                                                                            <?php
                                                                            if($equipment['equipment_type']== 'Laptop'){
                                                                                ?>
                                                                            <img src="./template2/dist/img/laptop.png" alt="logo" style="width:50px;">
                                                                                <?php
                                                                            }else if($equipment['equipment_type']== 'Speaker'){
                                                                                ?>
                                                                                <img src="./template2/dist/img/microphone.png" alt="logo" style="width:50px;">
                                                                                <?php
                                                                            }else if($equipment['equipment_type']== 'Proyektor'){
                                                                                ?>
                                                                                <img src="./template2/dist/img/projector.png" alt="logo" style="width:50px;">
                                                                                <?php  
                                                                            }else if($equipment['equipment_type']== 'Obeng'){
                                                                                ?>
                                                                                <img src="./template2/dist/img/obeng.png" alt="logo" style="width:50px;">
                                                                                <?php  
                                                                            }
                                                                            else if($equipment['equipment_type']== 'Tablet'){
                                                                                ?>
                                                                                <img src="./template2/dist/img/tablet.png" alt="logo" style="width:50px;">
                                                                                <?php  
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                        <div class="card-wrap">
                                                                            <div class="card-header">
                                                                                <h4 name="equipment_type" id="equipment_type" value="<?php echo $equipment['equipment_type']; ?>"><?php echo $equipment['equipment_type']; ?></h4>
                                                                                <h4  value="<?php echo $equipment['brand_type']; ?>" id="brand_type" name="brand_type" ><?php echo $equipment['brand_type']; ?></h4>
                                                                            </div>
                                                                            <div class="card-body">
                                                                            <label  value="<?php echo $equipment['equipment_id']; ?>" id="equipment_id" name="equipment_id" ><?php echo $equipment['equipment_id']; ?></label><br>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                    <form id="selectedEquipmentForm" method="post" style="display:none;">
                                                                        <input type="hidden" id="selectedEquipmentId" name="equipment_id" value="">
                                                                        <input type="hidden" id="selectedEquipmentType" name="equipment_type" value="">
                                                                    </form>
                                                            <?php
                                                        }   
                                                    } else {
                                                        //echo "0";
                                                        echo "<div>kosong</div>";
                                                    }
                                                }                                               
                                            }
                                           // $connection->close();
                                            ?>         
                            </div> 
                        </div>
                            <div class="form-group mt-2" style="width:100%;">
                                    <div class="d-flex justify-content-center" style="">
                                        <button type="submit" name="Submit" id="Submit" class="btn btn-warning p-3" style="width:100vw; border-radius:20px;  border: white 1px solid;">
                                           <h2>BOOKING</h2> 
                                        </button>
                                        
                                        <?php
                                include "koneksi.php";

                                if (isset($_SESSION['err'])) {
                                    $err = $_SESSION['err'];
                                    echo '<div class="alert alert-warning alert-message">' . $err . '</div>';
                                    unset($_SESSION['err']);
                                }
                                if (isset($_POST['Submit'])) {
                                    
                                    $fullname = isset($_SESSION['fullname']) ? $_SESSION['fullname'] : '';
                                    $equipment_id = isset($_POST['equipment_id']) ? $_POST['equipment_id'] : '';                                    
                                    $equipment_type = isset($_POST['equipment_type']) ? $_POST['equipment_type'] : '';
                                    $from = isset($_POST['from']) ? $_POST['from'] : '';
                                    $to = isset($_POST['to']) ? $_POST['to'] : '';
                                    $qty = "1";
                                    $status = "Booking";
                                    
                                    $bookingNumbers = '';
                                    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                                    
                                    for ($i = 0; $i < 5; $i++) {
                                        $bookingNumbers .= $characters[rand(0, strlen($characters) - 1)];
                                    }
                                  

                                    $fromduration =  new DateTime($from);
                                    $toduration =  new DateTime($to);
                                    
                                    if (!$fromduration || !$toduration) {
                                        // Handle DateTime creation errors, e.g., invalid date format
                                        die("Invalid date format");
                                    }
                                    
                                    date_default_timezone_set('Asia/Jakarta');
                                    $interval = $fromduration->diff($toduration);
                                    $duration = $interval->format('%d hari %h jam %i : %S ');
                                    $datenow = date('Y/m/d H:i:s');                             
                                        

                                    if( $equipment_id == '' || $equipment_type == '' || $fullname == ''){
                                        $errorMessage = "data anda kosong!.";
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
                                    
                                    } else {
                                        $sql = "INSERT INTO bookings (equipment_id, equipment_type, from_timestamp, to_timestamp, booking_time, qty, fullname, booking_number, `date`, status) VALUES ('$equipment_id', '$equipment_type', '$from', '$to', '$duration', '$qty', '$fullname', '$bookingNumbers', '$datenow', '$status')";
                                        $result = mysqli_query($mysqli,$sql);
                                                if ($result) {
                                                    $SucMessage = "Booking anda telah di simpan,anda dapat mengecheck kode booking pada menu detail. ";
                                                    $script = "
                                                    document.addEventListener('DOMContentLoaded', function() {
                                                      swal.fire({
                                                        icon: 'success',
                                                        title: 'hello ".$_SESSION['fullname']."',
                                                        text: '{$SucMessage}'  
                                                    })    
                                                    });
                                                    ";
                                                    echo "<script>{$script}</script>";
                                                } else {
                                                    echo "Error: " . $sql . "<br>" . $mysqli->error;
                                                    die();
                                                }
                                    } 
                                }
                                // Menutup koneksi database
                                $mysqli->close();
                                ?>  
                                    </div>
                                </div>
                              
                            </div>     
                </div>
            </div>
        </form>
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
  <script src="./template2/dist/modules/summernote/summernote-lite.js"></script>
  <script src="./template2/dist/dist/sweetalert2.min.js"></script>
  <script>
        function Note(){          
        return new Promise((resolve) => {
        const confirmModal = `
            <div class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title ">PANDUAN  CARA BOOKING DEVICE</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="font-family:times-new-roman;">
                    <li>buat akun terlebih dahulu</li>
                    <li>setelah itu login dengan akun yang telah di buat.</li>
                    <li>pilih waktu yang akan digunakan untuk booking device, setidaknya lebih dari 1 menit dari waktu sekarang.</li>
                    <li>pilih waktu yang akan digunakan untuk mengembalikan device, setidaknya lebih dari 1 menit dari waktu booking device.</li>
                    <li>cek ketersediaan device, apabila ada ,user dapat membooking dengan cara mengclick device yang ingin di booking.</li>
                    <li>setelah itu tekan tombol booking, apabila sukses ,user dapat meihat kode boking dari menu " detail bokingan anda?".</li>
                    <li>setelah itu user dapat mencatat code booking / mengfoto untuk mengambil device pada ruangan IT barcode</li>
                    <li>setelah itu user dapat pergi ke ruangan IT barcode dan menginput code booking sebagai tanda peminjaman</li>
                    <li>setelah mendapat notif sukses,user dapat mengambil device sampai waktu yang telah di tentukan oleh user pada waktu pembokingan</li>
                    <li>setelah selesai melakukan peminjaman / jam pinjamnya sudah habis,user dapat menginput code booking lagi sebagai tanda sudah mengembalikan device.</li>
                    <li>setelah mendapatkan notif sukses,user dapat mengembalikan device pada tempat seperti semula.</li>                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" onclick="resolveConfirm(true)"><i class="fa fa-thumbs-up"></i> mengerti!</button>
                </div>
                </div>
            </div>
            </div>
        `;

        // Append the modal to the body
        $('body').append(confirmModal);

        // Show the modal
        $('.modal').modal('show');

        // Resolve the promise based on user action
        window.resolveConfirm = (result) => {
            $('.modal').modal('hide');
            resolve(result);
        };

        // Remove the modal from the DOM when it's hidden
        $('.modal').on('hidden.bs.modal', function (e) {
            $(this).remove();
        });
        });
  
        }

        function selectEquipment(equipmentType, equipmentId) {
            var allCards = document.querySelectorAll('.item.card');
            allCards.forEach(function(card) {
                card.classList.remove('selected-card');
            });

            // Add the selected class to the clicked card
            var selectedCard = document.querySelector('.item.card[data-equipment-id="' + equipmentId + '"]');
            selectedCard.classList.add('selected-card');

            // Update selected equipment variables
            selectedEquipmentId = equipmentId;
            selectedEquipmentType = equipmentType;
            console.log(equipmentId,equipmentType);
            // Update hidden input fields
            document.getElementById('selectedEquipmentId').value = equipmentId;
            document.getElementById('selectedEquipmentType').value = equipmentType;
         }



            const currentDateTime = new Date(); // Get the current date and time

            const fromPicker = flatpickr('#from', {
                enableTime: true,
                dateFormat: "Y-m-d H:i:S",
                defaultDate: currentDateTime, // Set the default date and time
                onChange: function(selectedDatesfrom, dateStr) {
                    localStorage.setItem('selectedDatefrom', dateStr);
                }
            });

            const toPicker = flatpickr('#to', {
                enableTime: true,
                dateFormat: "Y-m-d H:i:S",
                defaultDate: currentDateTime, // Set the default date and time
                onChange: function(selectedDatesto, dateStr) {
                    localStorage.setItem('selectedDateto', dateStr);
                }
            });



            // Mengambil tanggal yang disimpan dari localStorage saat halaman dimuat
            const savedDatefrom = localStorage.getItem('selectedDatefrom');
            if (savedDatefrom) {
                document.getElementById('from').value = savedDatefrom;
               // location.reload()

            }

            const savedDateto = localStorage.getItem('selectedDateto');
            if (savedDateto) {
                document.getElementById('to').value = savedDateto;

            }
        </script>
</body>


</html>