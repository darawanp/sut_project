<?php session_start();
require_once '../database/connect.php';
$service_title = $_POST['service_title'];
$service_details = $_POST['service_details'];

$service_no = isset($_POST['service_no']) ? $_POST['service_no'] : null;
if ($service_no) {
    $updateSql = "UPDATE service SET service_title='".$service_title."', service_details='".$service_details."' WHERE service_no='".$service_no."'";
    $excute = mysqli_query($conn,$updateSql);
    if ($excute) {
        echo '<script>
           window.location.href="service.php";
           </script>';
    }
}else {
    echo '<script>
    alert("ไม่พบข้อมูล");
    window.history.back();
    </script>';
}
?>