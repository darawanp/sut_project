<?php
require_once '../database/connect.php';
$news_no = isset($_GET['news_no']) ? $_GET['news_no'] : null;

    // หลังจากลบเสร็จให้รีเฟรชกลับไปที่หน้าเดิม
    header("Location: news-admin.php");
if ($news_no) {
    $deleteSql = "DELETE FROM news WHERE news_no='".$news_no."'";
    $excute = mysqli_query($conn, $deleteSql);
    echo '<script>
        window.history.back();
        </script>';
}else {
    echo '<script>
        alert("ไม่พบข้อมูล");
        window.location.href = "news-admin.php";
        </script>';
}
?>