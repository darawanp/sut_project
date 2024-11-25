<?php
session_start();
require_once '../database/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $download_no = intval($_POST['download_no']);
    $file_name = $_POST['file_name'];
    $file_type = $_POST['file_type'];
    $doc_cate_no = intval($_POST['doc_cate_no']);
    $old_file_path = $_POST['old_file_path'];

    // ตรวจสอบการอัปโหลดไฟล์ใหม่
    if (isset($_FILES['file_path']) && $_FILES['file_path']['error'] == UPLOAD_ERR_OK) {
        $file_path = basename($_FILES['file_path']['name']); // เส้นทางที่ต้องการบันทึกไฟล์ใหม่
        $file_path_name = '../document/' .$file_path;
        move_uploaded_file($_FILES['file_path']['tmp_name'], $file_path_name); // อัปโหลดไฟล์ใหม่
        
        // หากมีการอัปโหลดไฟล์ใหม่ ให้อัปเดตฐานข้อมูล
        $sqlUpdate = "UPDATE download SET file_name = ?, file_type = ?, doc_cate_no = ?, file_path = ? WHERE download_no = ?";
        $stmt = mysqli_prepare($conn, $sqlUpdate);
        mysqli_stmt_bind_param($stmt, 'ssisi', $file_name, $file_type, $doc_cate_no, $file_path, $download_no);
    } else {
        // ถ้าไม่อัปโหลดไฟล์ใหม่ ให้ใช้ไฟล์เก่า
        $file_path = $old_file_path; // ใช้ไฟล์เก่า
        $sqlUpdate = "UPDATE download SET file_name = ?, file_type = ?, doc_cate_no = ?, file_path = ? WHERE download_no = ?";
        $stmt = mysqli_prepare($conn, $sqlUpdate);
        mysqli_stmt_bind_param($stmt, 'ssisi', $file_name, $file_type, $doc_cate_no, $file_path, $download_no);
    }

    // ทำการอัปเดตข้อมูลในฐานข้อมูล
    if (mysqli_stmt_execute($stmt)) {
        echo "<script type='text/javascript'>";
        echo "alert('บันทึกข้อมูลสำเร็จ');";
        echo "window.location = 'download.php'; ";
        echo "</script>";
    } else {
        // echo ": " . mysqli_error($conn);
        echo "<script type='text/javascript'>";
        echo "alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล');";
        echo "window.location = 'downloadUpdate.php'; ";
        echo "</script>";
    }
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>
