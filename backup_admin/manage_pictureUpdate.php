<?php
session_start();
require_once '../database/connect.php';

// รับค่าจากฟอร์ม
$picture_no = intval($_POST['picture_no']);
$picture_file_name = "";

// ตรวจสอบว่ามีการอัปโหลดไฟล์รูปภาพใหม่หรือไม่
if (isset($_FILES['picture_file']) && $_FILES['picture_file']['error'] == UPLOAD_ERR_OK) {
    // อัปโหลดไฟล์รูปภาพใหม่และเก็บเฉพาะชื่อไฟล์
    $picture_file_name = basename($_FILES['picture_file']['name']);
    $picture_file = '../pic/slide/' . $picture_file_name; // พาธสำหรับการย้ายไฟล์
    move_uploaded_file($_FILES['picture_file']['tmp_name'], $picture_file);

    // เก็บเฉพาะชื่อไฟล์ลงในฐานข้อมูล
    $picture_file_name = mysqli_real_escape_string($conn, $picture_file_name);
} else {
    // หากไม่มีการอัปโหลดไฟล์ใหม่ ใช้ไฟล์เก่า
    $picture_file_name = mysqli_real_escape_string($conn, $_POST['old_picture_file']); // ค่าไฟล์เก่าที่ถูกส่งมาจากฟอร์ม
}

// ตรวจสอบว่ามี picture_no หรือไม่
if ($picture_no) {
    $updateSql = "UPDATE picture SET picture_file = '$picture_file_name' WHERE picture_no = $picture_no";
    $execute = mysqli_query($conn, $updateSql);

    if ($execute) {
        echo '<script>
                alert("ปรับปรุงรูปภาพสำเร็จ");
                window.location.href="manage_picture.php";
              </script>';
    } else {
        echo '<script>
                alert("เกิดข้อผิดพลาดในการปรับปรุงรูปภาพ");
                window.history.back();
              </script>';
    }
} else {
    echo '<script>
            alert("ไม่พบข้อมูล");
            window.history.back();
          </script>';
}

// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($conn);
?>
