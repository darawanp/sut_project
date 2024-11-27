<?php
require_once '../database/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $exam_date = $_POST['exam_date'];
    $exam_start_times = $_POST['exam_start_time'];
    $exam_end_times = $_POST['exam_end_time'];
    $num_proctors = $_POST['num_proctors'];
    $exam_type = $_POST['exam_type'];

    if ($exam_date && $exam_start_times && $exam_end_times && $num_proctors && $exam_type) {
        $sql = "INSERT INTO exam_schedule (exam_date, exam_start_times, exam_end_times, num_proctors, exam_type_id)
                VALUES (?, ?, ?, ?, ?)";

        // ตรวจสอบว่าการเตรียมคำสั่งสำเร็จหรือไม่
        if (!$stmt = $conn->prepare($sql)) {
            die("การเตรียมคำสั่ง SQL ล้มเหลว: " . $conn->error);
        }

        // วนลูปเพิ่มข้อมูลช่วงเวลา
        foreach ($exam_start_times as $index => $start_time) {
            $end_time = $exam_end_times[$index];
            $proctor_count = $num_proctors[$index]; // Get the proctor count for this time slot
            $stmt->bind_param("sssii", $exam_date, $start_time, $end_time, $proctor_count, $exam_type);

            if (!$stmt->execute()) {
                header("Location: examFinal.php?status=error");
                exit();
            }
        }

        // หากเพิ่มข้อมูลสำเร็จทั้งหมด
        header("Location: examFinal.php?status=success");
        exit();
    } else {
        header("Location: examFinal.php?status=warning");
        exit();
    }
}

?>
