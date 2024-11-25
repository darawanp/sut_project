<?php
require_once '../database/connect.php';
$service_no = $_POST['service_no'];
$service_title = $_POST['service_title'];
$service_details = $_POST['service_details'];

$insertSql = "INSERT INTO service(service_no, service_title, service_details) VALUES('".$service_no."','".$service_title."','".$service_details."')";
$excute = mysqli_query($conn,$insertSql);
if ($excute) {
    $last_id = $conn->insert_id;
    header("location:service.php");
}else {
    echo '<script
    alert("เพิ่มข้อมูลบริการไม่สำเร็จ");
    window.history.back();<script>';
}
?>