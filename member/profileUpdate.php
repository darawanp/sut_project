<?php
require_once '../database/connect.php';
$user_id = $_POST['user_id'];
$name = $_POST['name'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$tel = $_POST['tel'];

if ($user_id) {
    $updateSql = "UPDATE user SET name='".$name."',lastname='".$lastname."',email='".$email."',phone='".$phone."',tel='".$tel."' WHERE user_id='".$user_id."'";
    $excute = mysqli_query($conn,$updateSql);
    if ($excute) {
        echo '<script>window.history.back();</script>';
    }
}else {
    echo '<script>
        alert("ไม่พบข้อมูล สำเร็จ");
        window.history.back();</script>';
}
?>