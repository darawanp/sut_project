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

$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
if ($user_id) {
    $updateSql = "UPDATE user SET username='".$username."',password='".$password."',name='".$name."',lastname='".$lastname."',email='".$email."',phone='".$phone."',tel='".$tel."' WHERE user_id='".$user_id."'";
    $excute = mysqli_query($conn,$updateSql);
    if ($excute) {
        header("location:index_admin.php");
    }
}else {
    echo '<script>
        alert("ไม่พบข้อมูล สำเร็จ");
        window.history.back();</script>';
}
?>