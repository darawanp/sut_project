<?php
$servername = "localhost"; // ชื่อเซิร์ฟเวอร์
$username = "root";        // ชื่อผู้ใช้
$password = "";            // รหัสผ่าน
$dbname = "sut"; // ชื่อฐานข้อมูล

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_query($conn, "SET NAMES UTF8");

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
