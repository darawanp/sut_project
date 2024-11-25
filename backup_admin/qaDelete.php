<?php
require_once '../database/connect.php';
$QA_no = isset($_GET['QA_no']) ? $_GET['QA_no'] : null;
if ($QA_no) {
    $deleteSql = "DELETE FROM qa WHERE QA_no='".$QA_no."'";
    $excute = mysqli_query($conn, $deleteSql);
    header("Location:qa.php");
}else {
    echo '<script>
        alert("ไม่พบข้อมูล");
        window.location.href = "profile.php";
        </script>';
}
?>