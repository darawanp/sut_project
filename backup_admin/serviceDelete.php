<?php
require_once '../database/connect.php';
$service_no = isset($_GET['service_no']) ? $_GET['service_no'] : null;
if ($service_no) {
    $deleteSql = "DELETE FROM service WHERE service_no='".$service_no."'";
    $excute = mysqli_query($conn, $deleteSql);
    echo '<script>window.history.back();</script>';
}else {
    echo '<script>
        alert("ไม่พบข้อมูล");
        window.location.href = "profile.php";
        </script>';
}
?>