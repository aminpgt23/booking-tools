<?php
include "../koneksi.php";
$sql = "SELECT id, equipment_id, equipment_type, from_timestamp, to_timestamp, fullname, date, status FROM bookings";
$result = mysqli_query($mysqli, $sql);

if ($result != null) {
    $availabilityBookings = mysqli_fetch_all($result, MYSQLI_ASSOC);
    ob_start();
    if (!empty($availabilityBookings)) {
        foreach ($availabilityBookings as $key => $data) {
          $id = $data['id'];
            ?>
                    <tr>
                    <td class="text-center" style="font-family:Bahnschrift;">
                          <h3 class="mt-5">
                            <?php echo $key + 1 ; ?>
                          </h3>
                        </td>
                        <td>
                          <h3 class="text-center mt-5" style="font-family:Bahnschrift;">
                            <?php echo date('Y-m-d', strtotime($data['from_timestamp'])); ?>
                          </h3>
                        </td>
                        <td>
                          <h3 class="text-center mt-5" style="font-family:Bahnschrift;">
                            <?php echo date('Y-m-d', strtotime($data['to_timestamp'])); ?>
                          </h3>
                        </td>
                        <td>
                          <h3 class="text-center mt-5" style="font-family:Bahnschrift;">
                            <?php echo date('H:i', strtotime($data['from_timestamp']));?> - <?php echo date('H:i', strtotime($data['to_timestamp'])); ?>
                          </h3>
                        </td>
                          <td class=" d-flex justify-content-center">
                          <div class="card-header mb-1 mt-1 border border-light" style="border-radius:20px; width:90%; height:20%;">
                              <div class="d-flex mt-1">
                                      <div class="card d-flex align-self-center p-3" style=" border-radius:6vh;" >
                                        <?php
                                        if($data['equipment_type'] == "Laptop"){
                                          ?>
                                        <img src="./template2/dist/img/laptop.png" alt="logo" class="" style="width:40px; height:40px;">
                                          <?php
                                        }else if($data['equipment_type'] == "Proyektor"){
                                          ?>
                                        <img src="./template2/dist/img/projector.png" alt="logo" class="" style="width:40px; height:40px;">
                                          <?php
                                        }else if($data['equipment_type'] == "Speaker"){
                                          ?>
                                          <img src="./template2/dist/img/microphone.png" alt="logo" class="" style="width:40px; height:40px;">
                                          <?php
                                        }
                                        else if($data['equipment_type'] == "Tablet"){
                                          ?>
                                          <img src="./template2/dist/img/tablet.png" alt="logo" class="" style="width:40px; height:40px;">
                                          <?php
                                        }
                                        ?>
                                      </div>
                                <div class="pl-2 mt-1" style="height:50%;">
                                    <div class="form-group" style="font-family:Bahnschrift;"> 
                                    <label for="">Name :</label>
                                    <?php echo $data['fullname']?> 
                                    </div>
                                    <?php
                                      include "../koneksi.php";
                                      $name = $data['equipment_id'];
                                      $sql = "SELECT brand_type FROM equipment WHERE equipment_id = '$name' ";
                                      $result = mysqli_query($mysqli, $sql);
                                      if ($result){
                                          $availableTypes = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                          foreach ($availableTypes as $availableType) {
                                              ?>
                                              <div class="form-group" style="font-family: Bahnschrift;">
                                                  <label for="">Device :</label>
                                                  <?php echo $data['equipment_type']; ?>
                                                  <p class="d-inline" ><?php echo $availableType['brand_type']; ?></p>
                                              </div>
                                              <?php
                                          }
                                      }
                                      ?>
                                </div>
                                <div class="pl-4 mt-1" style="height:50%;">
                                      <div class="form-group" style="font-family:Bahnschrift;">
                                        <label for=""> Type : </label>
                                        <?php echo $data['equipment_id']; ?> 
                                      </div>
                                      <div class="form-group" style="font-family:Bahnschrift;">
                                          <label for=""> status : </label>
                                            <?php 
                                            if($data['status'] == "Booking"){
                                              ?>
                                              <span class="badge badge-danger d-inline-block">
                                                <?php echo $data['status'];?>
                                              </span>
                                              <?php
                                            }else if ($data['status'] == "Pinjam"){
                                              ?>
                                              <span class="badge badge-success d-inline-block">
                                                <?php echo $data['status'];?>
                                              </span>                             
                                              <?php
                                            }
                                            ?> 
                                      </div>
                                </div>
                                <div class="ml-auto mt-2">
                                  <div class="form-group">
                                  <a href="template.php?page=antrian/edit_antrian&id=<?php echo $id; ?>" name="edit" id="edit" class="btn btn-warning btn-sm"><i class="fa fa-pencil-alt"></i></a>
                                          <form id="del-<?php echo $id; ?>" method="post" action="template.php?page=antrian/delete&id=<?php echo $id; ?>" class="mt-1">
                                              <input type="hidden" name="equipment_id" value="<?php echo $id; ?>">
                                              <input type="hidden" name="Delete">
                                              <button type="button" class="btn btn-danger btn-sm" onclick="submitDel(<?php echo $id; ?>)">
                                                  <i class="fas fa-trash"></i>
                                              </button>
                                          </form>	
                                  </div>
                                </div>
                              </div>
                            </div>                       
                          </td>
                        </tr>                              
            <?php
        }
    } else {
        ?>
        <tr>
            <td class="text-center">
                BOOKING DATA NOT AVAILABLE
            </td>
        </tr>
        <?php
    }
    $html = ob_get_clean(); 
    echo json_encode(['html' => $html]); 
}
?>


