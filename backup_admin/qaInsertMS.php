<?php
require_once '../database/connect.php';
$MS_no = isset($_GET['MS_no']) ? $_GET['MS_no'] : null;

if ($MS_no) {
    $insertSql = "INSERT INTO qa(question,answer) SELECT question,answer FROM message WHERE MS_no='".$MS_no."'";
    $excute = mysqli_query($conn,$insertSql);
    if ($excute) {
    header("location:qa.php");
}   else {
        echo '<script
        alert("เพิ่มข้อมูลไม่สำเร็จ");
        window.history.back();<script>';
    }
}

?>