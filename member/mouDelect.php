<?php
require_once '../database/connect.php';
$mouid = isset($_GET['mouid']) ? $_GET['mouid'] : null;
if ($mouid) {
    $deleteSql = "DELETE FROM mou WHERE mouid='".$mouid."'";
    $excute = mysqli_query($conn, $deleteSql);
    echo '<script> window.history.back() </script>';
}else {
    echo '<script>
        alert("ไม่พบข้อมูล");
        window.location.href = "mouDB.php";
        </script>';
}
?>