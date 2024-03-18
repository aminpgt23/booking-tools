<?php
include "../koneksi.php";

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql = "SELECT equipment_id, COUNT(*) AS Jumlah 
        FROM itjobs.history 
        WHERE YEAR(STR_TO_DATE(DATE, '%Y-%m-%d')) = 2024
        GROUP BY equipment_id 
        ORDER BY equipment_id ASC";

$result = mysqli_query($mysqli, $sql);

$data = array(
    'labels' => array(),
    'values' => array()
);

while ($row = $result->fetch_assoc()) {
    $data['labels'][] = $row['equipment_id'];
    $data['values'][] = $row['Jumlah'];
}

// Close the database connection
$mysqli->close();

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>




