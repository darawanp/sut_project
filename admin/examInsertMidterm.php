<?php
require_once '../database/connect.php';
//ส่งค่ามาด้วยเมธอต post
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $exam_date = $_POST['exam_date'];
    $exam_time = $_POST['exam_time'];
    $num_proctors = $_POST['num_proctors'];
    $exam_type = $_POST['exam_type'];

    // ตรวจสอบว่าข้อมูลครบถ้วน
    if ($exam_date && $exam_time && $num_proctors && $exam_type) {
        $sql = "INSERT INTO exam_schedule (exam_date, exam_time, num_proctors, exam_type_id)
                VALUES (?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $exam_date, $exam_time, $num_proctors, $exam_type);

        if ($stmt->execute()) {
            // บันทึกสำเร็จ
            header("Location: examMidterm.php?status=success");
            exit();
        } else {
            // บันทึกไม่สำเร็จ
            header("Location: examMidterm.php?status=error");
            exit();
        }
    } else {
        // ข้อมูลไม่ครบ
        header("Location: examMidterm.php?status=warning");
        exit();
    }
}
?>