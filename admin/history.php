
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
        .card-header{
          animation: fadeIn 0.5;
        }
    </style>

  <ul class="float-right">     
    <li class="dropdown dropdown-list-toggle">
        <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep" aria-expanded="false">
            <button class="btn btn-secondary"><i class="ion-navicon-round"></i></button>
        </a>
        <div class="dropdown-menu dropdown-list dropdown-menu-right">
            <div class="dropdown-header">Filtering Data
                <form>
                    <div class="input-group m-1">
                        <input type="date" class="form-control border border-secondary mr-1">
                    </div>
                    <div class="input-group m-1">
                        <input type="text" name="name" id="name" class="form-control border border-secondary mr-1" onchange="SearchName();" placeholder="Search Name">
                    </div>
                </form>
            </div>
        </div>
    </li>
</ul>

  
<div class="p-2 table-responsive ">
  <table class="table table-striped">
    <thead class="bg-secondary" >
        <tr>
            <th class="text-center text-light">NO</th >
            <th class="text-center text-light">DATE</th>
            <th class="text-center text-light">TIME TO</th>
            <th class="text-center text-light">ACTUAL CLOSE</th>
            <th class="text-center text-light">INFORMASI  BOOKING</th>
        </tr>
    </thead>
          <?php
           include "./koneksi.php";
           $sql = "SELECT  equipment_id, equipment_type, from_timestamp, to_timestamp, fullname,  date, date_actual_close, status FROM history ORDER BY date DESC";
           $result = mysqli_query($mysqli,$sql);
           if($result != null){
             $availabilityBokings= mysqli_fetch_all($result, MYSQLI_ASSOC);
              if(!empty($availabilityBokings)){
                foreach($availabilityBokings as $key => $data){
                  ?>
                  <tbody >
                    <tr>
                        <td class="text-center" style="font-family:Bahnschrift;">
                          <h3 class="mt-5">
                            <?php echo $key + 1 ; ?>
                          </h3>
                        </td>
                        <td>
                          <h3 class="text-center mt-5" style="font-family:Bahnschrift;">
                            <?php echo date('Y-m-d', strtotime($data['date'])); ?>
                          </h3>
                        </td>
                        <td>
                          <h3 class="text-center mt-5" style="font-family:Bahnschrift;">
                           <?php echo date('H:i', strtotime($data['to_timestamp'])); ?>
                          </h3>
                        </td>
                        <td>
                          <h3 class="text-center mt-5" style="font-family:Bahnschrift;">
                            <?php echo $data['date_actual_close'];?>
                          </h3>
                        </td>
                          <td class=" d-flex justify-content-center">
                          <div class="card-header mb-1 mt-1 border border-light" style="border-radius:20px; width:34vw; height:16vh;">
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
                                        ?>
                                      </div>
                                <div class="pl-2 mt-1" style="height:50%;">
                                    <div class="form-group" style="font-family:Bahnschrift;"> 
                                    <label for="">Name :</label>
                                    <?php echo $data['fullname']?> 
                                    </div>
                                    <div class="form-group" style="font-family:Bahnschrift;">
                                    <label for="">Device :</label>
                                    <?php echo $data['equipment_type'];?>
                                    </div>
                                </div>
                                <div class="pl-4 mt-1" style="height:50%;">
                                      <div class="form-group" style="font-family:Bahnschrift;">
                                        <label for=""> Type : </label>
                                        <?php echo $data['equipment_id']?> 
                                      </div>
                                      <div class="form-group" style="font-family:Bahnschrift;">
                                          <label for=""> status : </label>
                                            <?php 
                                            if($data['status'] == "Close"){
                                              ?>
                                              <span class="badge badge-info d-inline-block">
                                                <?php echo $data['status'];?>
                                              </span>
                                              <?php
                                            }else if ($data['status'] == "Cancel"){
                                              ?>
                                              <span class="badge badge-warning d-inline-block">
                                                <?php echo $data['status'];?>
                                              </span>                             
                                              <?php
                                            }
                                            ?> 
                                      </div>
                                </div>
                              </div>
                            </div>                       
                          </td>
                        </tr>   
                  </tbody>                      
                  <?php
                }
              }else{
                ?>
                <tbody class="text-center" style="margin-bottom:-10px;">
                <tr>
                  <td class="text-center">
                    BOOKING DATA NOT AVAILABLE
                  </td>
                </tr>
                </tbody>
                <?php
              }
           }
          ?>
  </table>
</div>