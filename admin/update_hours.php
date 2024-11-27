<?php
require_once '../database/connect.php';// ไฟล์เชื่อมต่อฐานข้อมูล

header('Content-Type: application/json');

// รับข้อมูลจาก AJAX
$data = json_decode(file_get_contents('php://input'), true);
$personal_id = $data['personal_id'];
$added_hours = intval($data['added_hours']); // แปลงค่าที่ส่งมาจาก JS ให้เป็นตัวเลข

if ($personal_id && $added_hours >= 0) {
    // อัปเดตจำนวนคาบในฐานข้อมูล
    $sql = "UPDATE user SET amout_hour = COALESCE(amout_hour, 0) + ? WHERE personal_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $added_hours, $personal_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "ไม่สามารถบันทึกข้อมูลได้"]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "ข้อมูลไม่ถูกต้อง"]);
}

$conn->close();
?>
