<?php
require_once '../database/connect.php';
$about_no=$_POST['about_no'];
$about_title=$_POST['about_title'];
$about_details=$_POST['about_details'];
$about_type=$_POST['about_type'];
$about_img=$_POST['about_img'];

if ($about_img) {
    if (isset($_FILES['about_img'])) {
        $name_file =  $_FILES['about_img']['name'];
        $tmp_name =  $_FILES['about_img']['tmp_name'];
        $locate_img ="pic/";
        move_uploaded_file($tmp_name,$locate_img.$name_file);
    }
}
$insertSql = "INSERT INTO about(about_no, about_title, about_details, about_img, about_type) VALUES('".$about_no."','".$about_title."','".$about_details."','".$about_img."','".$about_type."')";
$excute = mysqli_query($conn,$insertSql);
if ($excute) {
    $last_id = $conn->insert_id;
    header("location:people-admin.php");
}else {
    echo '<script
    alert("เพิ่มข้อมูลบุคลากรไม่สำเร็จ");
    window.history.back();<script>';
}
?>