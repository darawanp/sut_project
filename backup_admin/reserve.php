<?php
header('Content-Type: application/json');
require 'db_connection.php'; // ไฟล์เชื่อมต่อฐานข้อมูล

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['seats'])) {
    $seats = $data['seats'];
    $success = true;

    foreach ($seats as $seat) {
        $sql = "INSERT INTO reservations (seat_number, status) VALUES ('$seat', 'reserved')";
        if (!mysqli_query($conn, $sql)) {
            $success = false;
            break;
        }
    }

    echo json_encode(["success" => $success]);
} else {
    echo json_encode(["success" => false, "message" => "ไม่มีข้อมูลที่นั่ง"]);
}
?>
