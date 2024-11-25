<?php
echo '<meta charset="UTF-8">';
require_once '../database/connect.php';

// ตรวจสอบการเชื่อมต่อฐานข้อมูล
if (!$conn) {
    die("Database connection error: " . mysqli_connect_error());
}

if (isset($_POST['agencyname_thai']) && isset($_POST['agencyname_eng']) && isset($_POST['abbreviation_thai']) && isset($_POST['abbreviation_eng']) && isset($_POST['campus'])) {
    $agencyname_thai = mysqli_real_escape_string($conn, $_POST['agencyname_thai']);
    $agencyname_eng = mysqli_real_escape_string($conn, $_POST['agencyname_eng']);
    $abbreviation_thai = mysqli_real_escape_string($conn, $_POST['abbreviation_thai']);
    $abbreviation_eng = mysqli_real_escape_string($conn, $_POST['abbreviation_eng']);
    $campus = mysqli_real_escape_string($conn, $_POST['campus']);

    //อัพโหลดรูปโลโก้หน่วยงาน
    $newimg = "";
    if (isset($_FILES['agency_img']) && $_FILES['agency_img']['error'] == 0) {
        $news_img = $_FILES['agency_img'];

        // ตรวจสอบประเภทไฟล์
        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');
        $news_img_ext = strtolower(pathinfo($news_img['name'], PATHINFO_EXTENSION));

        if (in_array($news_img_ext, $allowed_ext)) {
            $news_img_name = $news_img['name'];

            // อัปโหลดไฟล์หลัก
            if (move_uploaded_file($news_img['tmp_name'], "../pic/logo/" . $news_img_name)) {
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

    // แทรกข้อมูลลงในฐานข้อมูล
    $sql = "INSERT INTO agency_university(agency_img, agencyname_thai, agencyname_eng, abbreviation_thai, abbreviation_eng, campus) 
            VALUES('$newimg', '$agencyname_thai', '$agencyname_eng', '$abbreviation_thai', '$abbreviation_eng', '$campus')";

    $result = mysqli_query($conn, $sql);

    // ตรวจสอบผลลัพธ์
    if (!$result) {
        die("Error in query: $sql " . mysqli_error($conn));
    }

    // แสดงผลลัพธ์
    if ($result) {
        echo "<script type='text/javascript'>";
        echo "window.location = 'agency.php'; ";
        echo "</script>";
    } else {
        echo "<script type='text/javascript'>";
        echo "alert('เกิดข้อผิดพลาด กรุณาลองอีกครั้ง');";
        echo "window.location = 'agencyCreate.php'; ";
        echo "</script>";
    }
}else {
    die("Error: Missing POST values.");
}
?>