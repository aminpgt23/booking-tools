<?php
include "../koneksi.php";

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql = "SELECT fullname, COUNT(*) AS Jumlah 
        FROM itjobs.history 
        WHERE YEAR(STR_TO_DATE(DATE, '%Y-%m-%d')) = 2024
        -- AND MONTH(STR_TO_DATE(DATE, '%Y-%m-%d')) = '1' 
        GROUP BY fullname 
        ORDER BY fullname ASC";

$result = mysqli_query($mysqli, $sql);

$data = array(
    'labels' => array(),
    'values' => array()
);

while ($row = $result->fetch_assoc()) {
    $data['labels'][] = $row['fullname'];
    $data['values'][] = $row['Jumlah'];
}

// Close the database connection
$mysqli->close();

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
