<?php
require_once '../database/connect.php';
$download_no = isset($_GET['download_no']) ? $_GET['download_no'] : null;
if ($download_no) {
    $deleteSql = "DELETE FROM download WHERE download_no='".$download_no."'";
    $excute = mysqli_query($conn, $deleteSql);
    echo '<script>
        window.location.href = "download-admin.php";
        </script>';
}else {
    echo '<script>
        alert("ไม่พบข้อมูล");
        window.location.href = "message.php";
        </script>';
}
?>