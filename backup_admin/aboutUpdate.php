<?php
require_once '../database/connect.php';
$about_title = $_POST['about_title'];
$about_details = $_POST['about_details'];
$about_img = $_POST['about_img'];
$about_type = $_POST['about_type'];

$about_no = isset($_POST['about_no']) ? $_POST['about_no'] : null;
if ($about_no) {
    $updateSql = "UPDATE about SET about_title='".$about_title."',about_details='".$about_details."',about_img='".$about_img."',about_type='".$about_type."' WHERE about_no='".$about_no."'";
    $excute = mysqli_query($conn,$updateSql);
    if ($excute) {
        echo '<script>
            window.history.back();</script>';
    }
}else {
    echo '<script>
        alert("ไม่พบข้อมูล สำเร็จ");
        window.history.back();</script>';
}


?>