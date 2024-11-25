<?php
require_once '../database/connect.php';
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;
if ($user_id) {
    $deleteSql = "DELETE FROM user WHERE user_id='".$user_id."'";
    $excute = mysqli_query($conn, $deleteSql);
    header("Location:profile.php");
}else {
    echo '<script>
        alert("ไม่พบข้อมูล");
        window.location.href = "profile.php";
        </script>';
}
?>