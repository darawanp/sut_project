<?php session_start();
require_once '../database/connect.php';

// รับค่าจากฟอร์ม
$about_no = intval($_POST['about_no']);
$about_title = mysqli_real_escape_string($conn, $_POST['about_title']);
$about_details = mysqli_real_escape_string($conn, $_POST['about_details']);
$about_img = "";

// ตรวจสอบว่ามีการอัปโหลดไฟล์รูปภาพใหม่หรือไม่
if (isset($_FILES['about_img']) && $_FILES['about_img']['error'] == UPLOAD_ERR_OK) {
    // อัปโหลดไฟล์รูปภาพใหม่และเก็บเฉพาะชื่อไฟล์
    $about_img_name = basename($_FILES['about_img']['name']);
    $about_img = '../pic/people/' . $about_img_name; // พาธสำหรับการย้ายไฟล์
    move_uploaded_file($_FILES['about_img']['tmp_name'], $about_img);
    // เก็บเฉพาะชื่อไฟล์ลงในฐานข้อมูล
    $about_img_name = mysqli_real_escape_string($conn, $about_img_name);
} else {
    // หากไม่มีการอัปโหลดไฟล์ใหม่ ใช้ไฟล์เก่า
    $about_img_name = mysqli_real_escape_string($conn, $_POST['old_picture_file']); // ค่าไฟล์เก่าที่ถูกส่งมาจากฟอร์ม
}

if ($about_no) {
    $updateSql = "UPDATE about SET  
                    about_title = '$about_title',
                    about_details = '$about_details',
                    about_img = '$about_img_name'
                  WHERE about_no = $about_no";
    $execute = mysqli_query($conn, $updateSql);
    if ($execute) {
        echo '<script>
            window.location.href="people.php";
            </script>';
    } else {
        echo '<script>
            alert("เกิดข้อผิดพลาดในการปรับปรุงรูปภาพ");
            window.history.back();
            </script>';
    }
}else {
    echo '<script>
            alert("ไม่พบข้อมูล");
            window.history.back();
          </script>';
}
// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($conn);

?>