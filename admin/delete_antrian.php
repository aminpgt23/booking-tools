<?php
include './koneksi.php';
include './admin/antrian.php';

if (isset($_GET["id"])) {
    $equipmentIdToDelete = $_GET['id'];
    if ($mysqli->connect_errno) {
        echo "Gagal melakukan koneksi ke MySQL: " . $mysqli->connect_error;
        exit();
    }

    $sqlGet = "SELECT * from bookings where id =?";
    $stmtGet = $mysqli->prepare($sqlGet);
    if (!$stmtGet) {
        die("Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
    }
    $stmtGet->bind_param("s", $equipmentIdToDelete);
    $stmtGet->execute();
    $stmtGet->bind_result($Id, $equipmentId, $type, $from, $to, $time, $qty, $fullname, $booking, $date, $status1);
    if ($stmtGet->fetch()) {
        $status = "Cancel";
        date_default_timezone_set('Asia/Jakarta');
        $datetime = date('Y/m/d H:i:s');
        $stmtGet->close();

        // Insert into history
        $sqlHistory = "INSERT INTO history (equipment_id, equipment_type, from_timestamp, to_timestamp, booking_time, qty, fullname, booking_number, `date`, date_actual_close,  status )
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtHistory = $mysqli->prepare($sqlHistory);
        if (!$stmtHistory) {
            die("Prepare failed1: (" . $mysqli->errno . ") " . $mysqli->error);
        }
        $stmtHistory->bind_param("sssssssssss", $equipmentId, $type, $from, $to, $time, $qty, $fullname, $booking, $date, $datetime, $status);
        if ($stmtHistory->execute()) {
            $sql = "DELETE FROM `itjobs`.`bookings` WHERE `id` =?";
            $stmt = $mysqli->prepare($sql);
            if (!$stmt) {
                die("Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
            }
            $stmt->bind_param("s", $equipmentIdToDelete);
            if ($stmt->execute()) {
                $SucMessage = "antrian telah Di berhentikan!";
                $script = "
                    document.addEventListener('DOMContentLoaded', function () {
                        Swal.fire({
                            icon: 'success',
                            title: 'hello " . $_SESSION['fullname'] . "',
                            text: ' {$SucMessage}'
                        }).then(function () {
                            window.location.href = 'template.php?page=antrian';
                        });
                    });
                ";
                echo "<script>{$script}</script>";
            } else {
                echo "Error deleting the antrian.";
            }
            $stmt->close();
        }
        $stmtHistory->close();
    }
}
?>
