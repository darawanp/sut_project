<?php
require_once '../database/connect.php';
$username = $_POST['username'];
$password = $_POST['password'];
$name = $_POST['name'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$tel = $_POST['tel'];
$ag_id = $_POST['ag_id'];
$user_type = $_POST['user_type'];
$status = $_POST['status'];

// ตรวจสอบว่า username มีอยู่ในฐานข้อมูลหรือไม่
$query = "SELECT username FROM user WHERE username=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo '<script>
        alert("Username นี้มีคนใช้แล้ว");
        window.history.back();</script>';
} else {
    // ถ้าไม่มี username ซ้ำ ก็ทำการเพิ่มข้อมูล
    $insertSql = "INSERT INTO user(username, password, name, lastname, email, phone, tel, user_type, status, ag_id) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtInsert = $conn->prepare($insertSql);
    $stmtInsert->bind_param("sssssssssi", $username, $password, $name, $lastname, $email, $phone, $tel, $user_type, $status, $ag_id);
    
    if ($stmtInsert->execute()) {
        header("Location: profile.php");
    } else {
        echo '<script>
        alert("เพิ่มข้อมูลผู้ใช้ไม่สำเร็จ");
        window.history.back();</script>';
    }
}

$stmt->close();
$stmtInsert->close();
$conn->close();
?>
