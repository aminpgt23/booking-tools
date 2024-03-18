<?php

                        include "../koneksi.php";
                        if ($mysqli->connect_errno) {
                            echo "Gagal melakukan koneksi ke MySQL: " . $mysqli->connect_error;
                            exit();
                        }  
                        
                        $sql = "SELECT id , equipment_id, equipment_type, qty, brand_type FROM equipment ORDER BY equipment_type ASC";
                        $result = mysqli_query($mysqli,$sql);                      
                        if($result){
                            ob_start(); 
                            $availabilityDevice = mysqli_fetch_all($result, MYSQLI_ASSOC);
                            foreach( $availabilityDevice as $key => $data){ 
                              $id = $data['id'];
                                ?> 
                                    <tr>
                                      <td width="40">
                                        <?php echo $key + 1 ?>                                             
                                      </td>
                                      <td>
                                        <?php echo $data['equipment_id'] ?>
                                      </td>
                                      <td>
                                        <?php echo $data['brand_type'] ?>
                                      </td>
                                      <td>
                                        <?php echo $data['equipment_type'] ?>
                                      </td>
                                      <td>
                                        <?php echo $data['qty'] ?>
                                      </td>
                                      <td style="width:15%">
                                      <a href="template.php?page=device/edit_device&id=<?php echo $id; ?>" name="edit" id="edit" class="btn btn-warning btn-sm"><i class="fa fa-pencil-alt"></i></a>
                                          <form id="del-<?php echo $id; ?>" method="post" action="template.php?page=device/delete&id=<?php echo $id; ?>" class="d-inline" role="form">
                                              <input type="hidden" name="equipment_id" id="equipment_id" value="<?php echo $id; ?>">
                                              <input type="hidden" name="Delete" id="Delete">
                                              <button type="button" name="button" class="btn btn-danger btn-sm" onclick="submitDel(<?php echo $id; ?>)">
                                                  <i class="fas fa-trash"></i>
                                              </button>
                                          </form>	
                                 
                                      </td> 
                                    </tr>
                                <?php
                            }
                            $data = ob_get_clean(); 
                            echo json_encode(['data' => $data]); 
                        }
                        ?>   