
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
  <?php

  if (isset($_GET['id'])) {
    $Id = $_GET['id'];

    $sql = "SELECT * FROM bookings WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $Id);
    $stmt->execute();
    $stmt->bind_result($Id, $equipmentId, $type, $from, $to, $time, $qty, $fullname, $booking, $date, $status);
    if ($stmt->fetch()) {
      ?>
      <div class="card">
        <div class="card-header">
            <h4>Edit Antrian</h4>
        </div>
          <form class="form form-card p-3" id="form"  method="post" role="form">
            <div class="row justify-content-between text-left">
                <div class="form-group col-sm-6 flex-column d-flex"> 
                    <label class="form-control-label px-3">Type Device</label>
                    <input type="text" name="equipment_id" id="equipment_id" value="<?php echo $equipmentId; ?>" class="form-control border border-secondary">
                </div>
                <div class="form-group col-sm-6 flex-column d-flex">
                    <label class="form-control-label px-3">Nama Device</label>
                    <input type="text" name="equipment_type" id="equipment_type" value="<?php echo $type; ?>" class="form-control border border-secondary">
                </div>
            </div>
            <div class="row justify-content-between text-left">
                <div class="form-group col-sm-6 flex-column d-flex">
                    <label class="form-control-label px-3">From</label> 
                    <input type="datetime" id="from_timestamp" name="from_timestamp" value="<?php echo $from; ?>" placeholder="" class="form-control border border-secondary">
                </div>
                <div class="form-group col-sm-6 flex-column d-flex">
                    <label class="form-control-label px-3">To</label> 
                    <input type="datetime" id="to_timestamp" name="to_timestamp" value="<?php echo $to; ?>" placeholder="" class="form-control border border-secondary">
                </div>
            </div>
            <div class="row justify-content-between text-left">
                <div class="form-group col-sm-6 flex-column d-flex">
                    <label class="form-control-label px-3">Time</label> 
                    <input type="datetime" id="booking_time" name="booking_time" value="<?php echo $time; ?>" placeholder="" class="form-control border border-secondary" readonly>
                </div>
                <div class="form-group col-sm-6 flex-column d-flex">
                    <label class="form-control-label px-3">Qty</label> 
                    <input type="number" id="qty" name="qty" value="<?php echo $qty; ?>" placeholder="" class="form-control border border-secondary" readonly>
                </div>
            </div>
            <div class="row justify-content-between text-left">
                <div class="form-group col-sm-6 flex-column d-flex">
                    <label class="form-control-label px-3">Fullname</label> 
                    <input type="text" id="fullname" name="fullname" value="<?php echo $fullname; ?>" placeholder="" class="form-control border border-secondary" readonly>
                </div>
                <div class="form-group col-sm-6 flex-column d-flex">
                    <label class="form-control-label px-3">Booking Number</label> 
                    <input type="text" id="booking_number" name="booking_number" value="<?php echo $booking; ?>" placeholder="" class="form-control border border-secondary" readonly>
                </div>
            </div>
            <div class="row justify-content-between text-left">
                <div class="form-group col-sm-6 flex-column d-flex">
                    <label class="form-control-label px-3">Date</label> 
                    <input type="datetime" id="date" name="date" value="<?php echo $date; ?>" placeholder="" class="form-control border border-secondary" readonly>
                </div>
                <div class="form-group col-sm-6 flex-column d-flex">
                    <label class="form-control-label px-3">Status</label> 
                    <input type="text" id="status" name="status" value="<?php echo $status; ?>" placeholder="" class="form-control border border-secondary" readonly>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-6">
                    <button type="submit" name="submit" id="submit" class="btn btn-success btn-sm" style="border-radius:15px">
                        <i class="fas fa-paper-plane"></i> apply
                    </button>
                </div>
            </div>
          </form>
                      <?php
                      include "./koneksi.php";
                      if(isset($_POST['submit'])){
                      $Id = $_GET['id'];
                      $equipment_id = isset($_POST['equipment_id']) ? $_POST['equipment_id'] : '';
                      $equipment_type = isset($_POST['equipment_type']) ? $_POST['equipment_type'] : '';
                      $from = isset($_POST['from_timestamp']) ? $_POST['from_timestamp'] : '';
                      $to = isset($_POST['to_timestamp']) ? $_POST['to_timestamp'] : '';
                      $time = isset($_POST['booking_time']) ? $_POST['booking_time'] : '';
                      $qty = isset($_POST['qty']) ? $_POST['qty'] : '';
                      $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
                      $booking = isset($_POST['booking_number']) ? $_POST['booking_number'] : '';
                      $date = isset($_POST['date']) ? $_POST['date'] : '';
                      $status = isset($_POST['status']) ? $_POST['status'] : '';
                      $sqlUpdate = "UPDATE bookings SET equipment_id = ?, equipment_type = ?, from_timestamp = ?, to_timestamp = ?, booking_time = ?, qty = ?, fullname = ?, booking_number = ?, `date` = ?, `status` = ? WHERE id = ?";
                      $stmt = $mysqli->prepare($sqlUpdate);
                      if(!$stmt){
                          die("Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
                      }
                  
                      $stmt->bind_param("ssssssssssi", $equipment_id, $equipment_type, $from, $to, $time, $qty, $fullname, $booking, $date, $status, $Id);                  
                      if($stmt->execute()){
                          $successMessage = "antrian berhasil di Update!";
                          $script = "
                          document.addEventListener('DOMContentLoaded', function() {                                                       
                                  swal.fire({
                                      icon: 'success',
                                      title: 'Hello',
                                      text: '{$successMessage}'  
                                  }) .then(function () {
                                      window.location.href = 'template.php?page=antrian';
                                  });                                                    
                          });
                          ";
                          echo "<script>{$script}</script>";
                      }else{
                          $errorMessage = "Data ditolak";
                          $script = "
                          document.addEventListener('DOMContentLoaded', function() {                                                       
                                  swal.fire({
                                      icon: 'error',
                                      title: 'Hello',
                                      text: '{$errorMessage}'  
                                  }).then(function () {
                                      window.location.href = 'template.php?page=antrian';
                                  });                                                     
                          });
                          ";
                          echo "<script>{$script}</script>";
                          echo "Error: " . $sql . "<br>" . $mysqli->error;
                          die();
                      }     
                  }
                  ?>
      </div>
      <?php
    } else {
        echo "Equipment not found!";
    }
    $stmt->close();
} else {
    echo "No equipment ID provided!";
}

?>
    


