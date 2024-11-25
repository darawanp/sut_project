<?php
session_start();
echo '<meta charset="UTF-8">';
require_once '../database/connect.php';

// ตรวจสอบการเชื่อมต่อฐานข้อมูล
if (!$conn) {
    die("Database connection error: " . mysqli_connect_error());
}

// รับค่า POST และทำการป้องกัน SQL Injection
if (isset($_POST['picture_no'])) {
    $picture_no = mysqli_real_escape_string($conn, $_POST['picture_no']);

    // สำหรับการอัปโหลดไฟล์หลัก
    $newPicture = "";
    if (isset($_FILES['picture_file']) && $_FILES['picture_file']['error'] == UPLOAD_ERR_OK) {
        $picture_file = $_FILES['picture_file'];

        // ตรวจสอบประเภทไฟล์
        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');
        $picture_file_ext = strtolower(pathinfo($picture_file['name'], PATHINFO_EXTENSION));

        if (in_array($picture_file_ext, $allowed_ext)) {
            // สร้างชื่อไฟล์ใหม่ที่ไม่ซ้ำกัน
            $picture_file_name =  basename($picture_file['name']);

            // อัปโหลดไฟล์หลัก
            if (move_uploaded_file($picture_file['tmp_name'], "../pic/slide/" . $picture_file_name)) {
                $newPicture = $picture_file_name; // เก็บชื่อไฟล์ภาพหลักไว้ในตัวแปร $newPicture
            } else {
                die("Error: Failed to upload main image.");
            }
        } else {
            die("Error: Invalid file type for the main image.");
        }
    } else {
        die("Error: No file was uploaded or there was an error with the file upload.");
    }

    // แทรกข้อมูลลงในฐานข้อมูล โดยใช้ $newPicture แทน $picture_file
    $sql = "INSERT INTO picture (picture_no, picture_file) 
            VALUES('$picture_no', '$newPicture')";

    $result = mysqli_query($conn, $sql);

    // ตรวจสอบผลลัพธ์
    if (!$result) {
        die("Error in query: $sql " . mysqli_error($conn));
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    mysqli_close($conn);

    // แสดงผลลัพธ์
    if ($result) {
        echo "<script type='text/javascript'>";
        echo "alert('อัปโหลดรูปภาพเรียบร้อย');";
        echo "window.location = 'manage_picture.php'; ";
        echo "</script>";
    } else {
        echo "<script type='text/javascript'>";
        echo "alert('เกิดข้อผิดพลาด กรุณาลองอีกครั้ง');";
        echo "window.location = 'manage_picture.php'; ";
        echo "</script>";
    }
} else {
    die("Error: Missing POST values.");
}
?>
