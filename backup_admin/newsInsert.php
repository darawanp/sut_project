<?php
session_start();
echo '<meta charset="UTF-8">';
require_once '../database/connect.php';

// ตรวจสอบการเชื่อมต่อฐานข้อมูล
if (!$conn) {
    die("Database connection error: " . mysqli_connect_error());
}

// รับค่า POST และทำการป้องกัน SQL Injection
if (isset($_POST['news_no']) && isset($_POST['news_date']) && isset($_POST['news_title']) && 
    isset($_POST['news_type']) && isset($_POST['news_details'])) {

    $news_no = mysqli_real_escape_string($conn, $_POST['news_no']);
    $news_date = mysqli_real_escape_string($conn, $_POST['news_date']);
    $news_title = mysqli_real_escape_string($conn, $_POST['news_title']);
    $news_type = mysqli_real_escape_string($conn, $_POST['news_type']);
    $news_details = mysqli_real_escape_string($conn, $_POST['news_details']);

    // ลบแท็ก <p></p> ที่ว่างออกจากเนื้อหาข่าว
    $news_details = preg_replace('/<p><\/p>/', '', $news_details);

    // สำหรับการอัปโหลดไฟล์หลัก
    $newimg = "";
    if (isset($_FILES['news_img']) && $_FILES['news_img']['error'] == 0) {
        $news_img = $_FILES['news_img'];

        // ตรวจสอบประเภทไฟล์
        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');
        $news_img_ext = strtolower(pathinfo($news_img['name'], PATHINFO_EXTENSION));

        if (in_array($news_img_ext, $allowed_ext)) {
            $news_img_name = $news_img['name'];

            // อัปโหลดไฟล์หลัก
            if (move_uploaded_file($news_img['tmp_name'], "../pic/newspicture/" . $news_img_name)) {
                $newimg = $news_img_name; // เก็บชื่อไฟล์ภาพหลักไว้ในตัวแปร $newimg
            } else {
                die("Error: Failed to upload main image.");
            }
        } else {
            die("Error: Invalid file type for the main image.");
        }
    } else {
        die("Error: No file was uploaded or there was an error with the file upload.");
    }

    // สำหรับการอัปโหลดไฟล์แกลเลอรีหลายไฟล์
    $uploaded_gallery_images = array();
    if (isset($_FILES['news_gallery']['name']) && count($_FILES['news_gallery']['name']) > 0) {
        foreach ($_FILES['news_gallery']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['news_gallery']['error'][$key] == 0) {
                // ตรวจสอบประเภทไฟล์
                $file_names = $_FILES['news_gallery']['name'];
                $gallery_img_ext = strtolower(pathinfo($file_names[$key], PATHINFO_EXTENSION));

                if (in_array($gallery_img_ext, $allowed_ext)) {
                    $new_gallery_name = $file_names[$key];

                    // อัปโหลดไฟล์แกลเลอรี
                    if (move_uploaded_file($tmp_name, "../pic/newspicture/" . $new_gallery_name)) {
                        $uploaded_gallery_images[] = $new_gallery_name;  // เก็บชื่อไฟล์ภาพแกลเลอรีในอาร์เรย์
                    } else {
                        die("Error: Failed to upload gallery image.");
                    }
                } else {
                    die("Error: Invalid file type for gallery images.");
                }
            }
        }
    }

    // ตรวจสอบว่ามีการอัปโหลดไฟล์แกลเลอรีหรือไม่
    if (empty($uploaded_gallery_images)) {
        die("Error: No gallery images were uploaded.");
    }

    // นำไฟล์ภาพแกลเลอรีทั้งหมดมาแปลงเป็นสตริงเพื่อเก็บในฐานข้อมูล
    $news_gallery_str = implode(",", $uploaded_gallery_images);

    // แทรกข้อมูลลงในฐานข้อมูล
    $sql = "INSERT INTO news (news_no, news_date, news_title, news_type, news_img, news_details, news_gallery) 
            VALUES('$news_no', '$news_date', '$news_title', '$news_type', '$newimg', '$news_details', '$news_gallery_str')";

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
        echo "alert('อัปโหลดไฟล์เรียบร้อย');";
        echo "window.location = 'news-admin.php'; ";
        echo "</script>";
    } else {
        echo "<script type='text/javascript'>";
        echo "alert('เกิดข้อผิดพลาด กรุณาลองอีกครั้ง');";
        echo "window.location = 'newsCreate.php'; ";
        echo "</script>";
    }

} else {
    die("Error: Missing POST values.");
}
?>
