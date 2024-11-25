<?php
session_start();
require_once '../database/connect.php';

// รับค่าจากฟอร์ม
$news_no = intval($_POST['news_no']);
$news_date = mysqli_real_escape_string($conn, $_POST['news_date']);
$news_title = mysqli_real_escape_string($conn, $_POST['news_title']);
$news_type = mysqli_real_escape_string($conn, $_POST['news_type']);
$news_details = mysqli_real_escape_string($conn, $_POST['news_details']);

// ตรวจสอบว่ามีการอัปโหลดไฟล์รูปภาพใหม่หรือไม่
$news_img = "";
if (isset($_FILES['news_img']) && $_FILES['news_img']['error'] == UPLOAD_ERR_OK) {
    // อัปโหลดไฟล์รูปภาพหลักใหม่
    $news_img_name = basename($_FILES['news_img']['name']);
    $news_img = '../pic/newspicture/' . $news_img_name; // พาธสำหรับการย้ายไฟล์
    move_uploaded_file($_FILES['news_img']['tmp_name'], $news_img);
    // เก็บเฉพาะชื่อไฟล์ลงในฐานข้อมูล
    $news_img_name = mysqli_real_escape_string($conn, $news_img_name);
} else {
    // หากไม่มีการอัปโหลดไฟล์ใหม่ ใช้ไฟล์เก่า
    $news_img_name = mysqli_real_escape_string($conn, $_POST['old_picture_file']); // ค่าไฟล์เก่าที่ถูกส่งมาจากฟอร์ม
}

// จัดการอัปโหลดไฟล์แกลเลอรีใหม่
$allowed_ext = array('jpg', 'jpeg', 'png', 'gif');
$uploaded_gallery_images = array();

if (isset($_FILES['news_gallery'])) {
    $gallery_files = $_FILES['news_gallery'];
    $total_files = count($gallery_files['name']);

    for ($i = 0; $i < $total_files; $i++) {
        if ($gallery_files['error'][$i] == UPLOAD_ERR_OK) {
            $file_name = basename($gallery_files['name'][$i]);
            $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            if (in_array($file_extension, $allowed_ext)) {
                $new_file_name = uniqid() . '-' . $file_name;
                $file_path = "newspicture/" . $new_file_name;

                if (move_uploaded_file($gallery_files['tmp_name'][$i], $file_path)) {
                    $uploaded_gallery_images[] = $new_file_name;
                }
            }
        }
    }
}

// ตรวจสอบว่ามีการอัปโหลดไฟล์แกลเลอรีใหม่หรือไม่
if (!empty($uploaded_gallery_images)) {
    $news_gallery_str = implode(",", $uploaded_gallery_images);
} else {
    // หากไม่มีการอัปโหลดไฟล์ใหม่ ใช้ไฟล์เก่า
    $news_gallery_str = $_POST['old_news_gallery']; // ค่าไฟล์เก่าที่ถูกส่งมาจากฟอร์ม
}

// ตรวจสอบว่ามี news_no หรือไม่
if ($news_no) {
    $updateSql = "UPDATE news SET 
                    news_date = '$news_date', 
                    news_title = '$news_title', 
                    news_type = '$news_type', 
                    news_img = '$news_img_name', 
                    news_details = '$news_details', 
                    news_gallery = '$news_gallery_str' 
                  WHERE news_no = $news_no";

    $execute = mysqli_query($conn, $updateSql);

    if ($execute) {
        echo '<script>
                alert("ปรับปรุงข่าวสำเร็จ");
                window.location.href="news-admin.php";
              </script>';
    } else {
        echo '<script>
                alert("เกิดข้อผิดพลาดในการปรับปรุงข่าว");
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
