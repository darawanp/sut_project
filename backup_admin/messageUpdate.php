<?php
session_start();
require_once '../database/connect.php';
$answer = $_POST['answer'];
$MS_no = isset($_POST['MS_no']) ? $_POST['MS_no'] : null;
if ($MS_no) {
    $updateSql = "UPDATE message SET answer='".$answer."' WHERE MS_no='".$MS_no."'";
    $excute = mysqli_query($conn, $updateSql);
    if ($excute) {
         echo '<script>
            window.location.href="message.php";
            </script>';
    }
}else {
    echo '<script>
    alert("ไม่พบข้อมูล");
    window.history.back();
    </script>';
}
?>