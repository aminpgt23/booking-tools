<?php
// Koneksi ke database (ganti nilainya sesuai dengan pengaturan database Anda)
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'itjobs';

$connection = new mysqli($host, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Mendapatkan data dari form (from, to, equipment_type, dan quantity)
$from = strtotime($_POST['from']);
$to = strtotime($_POST['to']);
$equipment_type = $_POST['equipment_type'];
$quantity = $_POST['quantity'];

// Mengecek ketersediaan alat dalam tabel equipment
$query = "SELECT id, qty FROM equipment WHERE equipment_type = '$equipment_type'";
$result = $connection->query($query);

if ($result->num_rows > 0) {
    $equipmentData = $result->fetch_assoc();
    $equipmentId = $equipmentData['id'];
    $availableQty = $equipmentData['qty'];

    // Memeriksa ketersediaan alat sesuai dengan jumlah yang diminta
    if ($availableQty >= $quantity) {
        // Memeriksa ketersediaan alat dalam rentang waktu yang diminta
        $checkAvailabilityQuery = "SELECT COUNT(*) AS count FROM bookings WHERE 
            equipment_id = $equipmentId AND
            ((from_timestamp <= $from AND to_timestamp >= $from) OR
            (from_timestamp <= $to AND to_timestamp >= $to) OR
            (from_timestamp >= $from AND to_timestamp <= $to))";

        $availabilityResult = $connection->query($checkAvailabilityQuery);
        $availabilityData = $availabilityResult->fetch_assoc();
        $bookedQuantity = $availabilityData['count'];

        if ($availableQty - $bookedQuantity >= $quantity) {
            // Memasukkan data pemesanan ke dalam tabel bookings
            $insertBookingQuery = "INSERT INTO bookings (equipment_id, from_timestamp, to_timestamp, booking_time, quantity)
                VALUES ($equipmentId, $from, $to, ($to - $from), $quantity)";

            if ($connection->query($insertBookingQuery) === TRUE) {
                echo "Equipment booked successfully!";
            } else {
                echo "Error: " . $insertBookingQuery . "<br>" . $connection->error;
            }
        } else {
            echo "Jumlah alat yang diminta tidak tersedia dalam rentang waktu tersebut.";
        }
    } else {
        echo "Jumlah alat yang diminta melebihi stok yang tersedia.";
    }
} else {
    echo "Tidak ada data alat yang sesuai dengan jenis yang diminta.";
}

$connection->close();
