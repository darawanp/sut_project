<?php
require_once '../database/connect.php';
$act_id = isset($_GET['act_id']) ? $_GET['act_id'] : null;
if ($act_id) {
    $deleteSql = "DELETE FROM activity WHERE act_id='".$act_id."'";
    $excute = mysqli_query($conn, $deleteSql);
    echo '<script> window.history.back() </script>';
}else {
    echo '<script>
        alert("ไม่พบข้อมูล");
        window.location.href = "activityDB.php";
        </script>';
}
?>