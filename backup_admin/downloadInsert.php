<?php
session_start();
require_once '../database/connect.php';
echo '<meta charset="UTF-8">';

// รับค่าจากฟอร์ม
$file_name = $_POST['file_name'];
$file_type = $_POST['file_type'];
$doc_cate_no = $_POST['doc_cate_no'];


// ตรวจสอบว่ามีการอัปโหลดไฟล์หรือไม่
$upload = $_FILES['file_path'];

if ($upload['name'] != '') { // ถ้ามีการเลือกไฟล์
    $path = "../document/";  
    $fileType = strtolower(pathinfo($upload['name'], PATHINFO_EXTENSION));
    $allowedTypes = array("pdf", "doc", "docx", "xls", "xlsx");

    if (!in_array($fileType, $allowedTypes)) {
        echo "ขออภัย เฉพาะไฟล์ PDF, DOC, DOCX, XLS และ XLSX เท่านั้น <br>";
        exit();
    }

    $newfilename = $upload['name'];
    $path_copy = $path . $newfilename;
    $path_link = $newfilename;

    // ตรวจสอบว่ามีไฟล์ชื่อเดียวกันอยู่หรือไม่
    if (file_exists($path_copy)) {
        echo "<script type='text/javascript'>";
        echo "alert('Error: File already exists!');";
        echo "window.location = 'downloadUpload.php'; ";
        echo "</script>";
        exit();
    }

    // อัปโหลดไฟล์ลงในโฟลเดอร์
    move_uploaded_file($upload['tmp_name'], $path_copy);
}

// ใช้ Prepared Statements สำหรับการแทรกข้อมูล
$sql = "INSERT INTO download (file_name, file_type, doc_cate_no, file_path) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error in prepare statement: " . $conn->error);
}

// Binding parameters
$stmt->bind_param("ssis", $file_name, $file_type, $doc_cate_no, $path_link);

// การดำเนินการคำสั่ง
$result = $stmt->execute();

// ปิดการเชื่อมต่อฐานข้อมูล
$stmt->close();
mysqli_close($conn);

// ตรวจสอบผลลัพธ์และแสดงข้อความ
if ($result) {
    echo "<script type='text/javascript'>";
    echo "alert('Upload File Successfully');";
    echo "window.location = 'download.php'; ";
    echo "</script>";
} else {
    echo "<script type='text/javascript'>";
    echo "alert('Error: Please try again');";
    echo "window.location = 'downloadUpload.php'; ";
    echo "</script>";
}
?>
