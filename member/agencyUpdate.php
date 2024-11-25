<?php session_start();
require_once '../database/connect.php';

// รับค่าจากฟอร์ม
$ag_id = intval($_POST['ag_id']);
$agencyname_thai = mysqli_real_escape_string($conn, $_POST['agencyname_thai']);
$agencyname_eng = mysqli_real_escape_string($conn, $_POST['agencyname_eng']);
$abbreviation_thai = mysqli_real_escape_string($conn, $_POST['abbreviation_thai']);
$abbreviation_eng = mysqli_real_escape_string($conn, $_POST['abbreviation_eng']);
$campus = mysqli_real_escape_string($conn, $_POST['campus']);
$agency_img = "";

// ตรวจสอบว่ามีการอัปโหลดไฟล์รูปภาพใหม่หรือไม่
if (isset($_FILES['agency_img']) && $_FILES['agency_img']['error'] == UPLOAD_ERR_OK) {
    // อัปโหลดไฟล์รูปภาพใหม่และเก็บเฉพาะชื่อไฟล์
    $agency_img_name = basename($_FILES['agency_img']['name']);
    $agency_img = '../pic/logo/' . $agency_img_name; // พาธสำหรับการย้ายไฟล์
    move_uploaded_file($_FILES['agency_img']['tmp_name'], $agency_img);

    // เก็บเฉพาะชื่อไฟล์ลงในฐานข้อมูล
    $agency_img_name = mysqli_real_escape_string($conn, $agency_img_name);
} else {
    // หากไม่มีการอัปโหลดไฟล์ใหม่ ใช้ไฟล์เก่า
    $agency_img_name = mysqli_real_escape_string($conn, $_POST['old_picture_file']); // ค่าไฟล์เก่าที่ถูกส่งมาจากฟอร์ม
}

if ($ag_id) {
    $updateSql = "UPDATE agency_university SET agencyname_thai = '$agencyname_thai', agencyname_eng = '$agencyname_eng', abbreviation_thai = '$abbreviation_thai', abbreviation_eng = '$abbreviation_eng', campus = '$campus', agency_img = '$agency_img_name' WHERE ag_id = $ag_id";
    $execute = mysqli_query($conn, $updateSql);
    if ($execute) {
        echo '<script>
            window.history.back();
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