<?php
require_once '../database/connect.php';
$picture_no = isset($_GET['picture_no']) ? $_GET['picture_no'] : null;
if ($picture_no) {
    $deleteSql = "DELETE FROM picture WHERE picture_no='".$picture_no."'";
    $excute = mysqli_query($conn, $deleteSql);
    echo '<script> window.history.back() </script>';
}else {
    echo '<script>
        alert("ไม่พบข้อมูล");
        window.location.href = "manage-picture.php";
        </script>';
}
?>