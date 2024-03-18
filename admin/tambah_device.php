
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
   
if(isset($_POST['submit'])){
    $equipment_id = isset($_POST['equipment_id']) ? $_POST['equipment_id'] : '';
    $equipment_type = isset($_POST['equipment_type']) ? $_POST['equipment_type'] : '';
    // echo $equipment_id;
    $qty = $_POST['qty'];
    $brand = $_POST['brand_type'];
    $sql = "INSERT INTO equipment (equipment_id, equipment_type, qty, brand_type) VALUES ('$equipment_id', '$equipment_type', '$qty' , '$brand') ";
    $result = mysqli_query($mysqli,$sql);
    if($result){
        $successMessage = "Device berhasil ditambahkan!";
        $script = "
        document.addEventListener('DOMContentLoaded', function() {                                                       
                swal.fire({
                    icon: 'success',
                    title: 'Hello',
                    text: '{$successMessage}'  
                }) .then(function () {
                    window.location.href = 'template.php?page=device';
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
                    window.location.href = 'template.php?page=device';
                });                                                     
        });
        ";
        echo "<script>{$script}</script>";
        echo "Error: " . $sql . "<br>" . $mysqli->error;
        die();
    }    
}
?>

    <div class="card">
        <div class="card-header">
            <h4>tambah device</h4>
        </div>
        <form class="form form-card p-3" id="form"  method="post" role="form">
            <div class="row justify-content-between text-left">
                <div class="form-group col-sm-6 flex-column d-flex"> 
                    <label class="form-control-label px-3">Type Device</label>
                    <input type="text" name="equipment_id" id="equipment_id" value="" class="form-control border border-secondary">
                </div>
                <div class="form-group col-sm-6 flex-column d-flex">
                    <label class="form-control-label px-3">Nama Device</label>
                    <input type="text" name="equipment_type" id="equipment_type" value="" class="form-control border border-secondary">
                </div>
            </div>
            <div class="row justify-content-between text-left">
                <div class="form-group col-sm-6 flex-column d-flex">
                    <label class="form-control-label px-3">Qty</label> 
                    <input type="number" id="qty" name="qty" value="" placeholder="" class="form-control border border-secondary">
                </div>
                <div class="form-group col-sm-6 flex-column d-flex">
                    <label class="form-control-label px-3">Brand Type</label> 
                    <input type="text" id="brand_type" name="brand_type" value="" placeholder="" class="form-control border border-secondary">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-6">
                    <button type="submit" name="submit" id="submit" class="btn btn-success btn-sm" style="border-radius:15px">
                        <i class="fas fa-paper-plane"></i> create
                    </button>
                </div>
            </div>
        </form>
    </div>