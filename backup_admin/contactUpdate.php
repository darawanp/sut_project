<?php
require_once '../database/connect.php';
$contact_address = $_POST['contact_address'];
$contact_university = $_POST['contact_university'];
$contact_tel = $_POST['contact_tel'];
$contact_email = $_POST['contact_email'];
$contact_no = isset($_POST['contact_no']) ? $_POST['contact_no'] : null;
if ($contact_no) {
    $updateSql = "UPDATE contact SET contact_address='".$contact_address."', contact_university='".$contact_university."', contact_tel='".$contact_tel."', contact_email='".$contact_email."' WHERE contact_no='".$contact_no."'";
    $excute = mysqli_query($conn, $updateSql);
    if ($excute) {
         echo '<script>
            window.history.back();
            </script>';
    }
}else {
    echo '<script>
    alert("ไม่พบข้อมูล");
    window.history.back();
    </script>';
}

?>