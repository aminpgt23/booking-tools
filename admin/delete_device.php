<?php
                                          include './koneksi.php';
                                          include './admin/device.php';
                                            if (isset($_GET["id"])) {
                                                $equipmentIdToDelete = $_GET['id'];                      
                                                $sql = "DELETE FROM `itjobs`.`equipment` WHERE `id` =?";
                                                $stmt = $mysqli->prepare($sql);
                                                if(!$stmt){
                                                  die("Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
                                                 }                        
                                                $stmt->bind_param("s", $equipmentIdToDelete);

                                                if ($stmt->execute()) {
                                                    $SucMessage = "Device telah Di Hapus!";
                                                    $script = "
                                                        document.addEventListener('DOMContentLoaded', function () {
                                                            Swal.fire({
                                                                icon: 'success',
                                                                title: 'hello " . $_SESSION['fullname'] . "',
                                                                text: ' {$SucMessage}'
                                                            }).then(function () {
                                                                window.location.href = 'template.php?page=device';
                                                            });
                                                        });
                                                    ";
                                                    echo "<script>{$script}</script>";
                                                } else {
                                                    echo "Error deleting the device.";
                                                }
                                                $stmt->close();
                                            }
                                            ?>