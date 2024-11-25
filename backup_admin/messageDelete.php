<?php
require_once '../database/connect.php';
$MS_no = isset($_GET['MS_no']) ? $_GET['MS_no'] : null;
if ($MS_no) {
    $deleteSql = "DELETE FROM message WHERE MS_no='".$MS_no."'";
    $excute = mysqli_query($conn, $deleteSql);
    echo '<script> window.history.back() </script>';
}else {
    echo '<script>
        alert("ไม่พบข้อมูล");
        window.location.href = "message.php";
        </script>';
}
?>