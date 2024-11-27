<?php
// รวมไฟล์เชื่อมต่อฐานข้อมูล
require_once '../database/connect.php';

// ตรวจสอบว่าได้รับ ID หรือไม่
if (isset($_GET['id'])) {
    $exam_id = $_GET['id'];

    // ลบข้อมูลจากฐานข้อมูล
    $sql = "DELETE FROM exam_schedule WHERE exam_id = '$exam_id'";

    // เชื่อมต่อกับฐานข้อมูลและทำการลบ
    if (mysqli_query($conn, $sql)) {
        // ถ้าลบสำเร็จ ให้กลับไปที่หน้า examSchedule.php พร้อมกับ parameter error
        header("Location: examSchedule.php?status=error");
        exit(); // หยุดการทำงานของ PHP หลังจาก header
    } else {
        // ถ้าลบไม่สำเร็จ
        header("Location: examSchedule.php?status=error");
        exit();
    }
}
