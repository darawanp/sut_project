<?php require_once '../database/connect.php';
$mouid = $_POST['mouid'];
$dates_tr = $_POST['dates_tr'];
$ag_id = $_POST['ag_id'];
$op_name = $_POST['op_name'];
$op_position = $_POST['op_position'];
$op_tel = $_POST['op_tel'];
$op_phone = $_POST['op_phone'];
$op_email = $_POST['op_email'];
$op_line = $_POST['op_line'];
$op_faculty = $_POST['op_faculty'];
$op_programs = $_POST['op_programs'];
$typeAct_no = $_POST['typeAct_no'];
$typeAct_custom = $_POST['typeAct_custom'];
$act_name = $_POST['act_name'];
$act_details = $_POST['act_details'];
$act_dateStart = $_POST['act_dateStart'];
$act_dateEnd = $_POST['act_dateEnd'];
$act_place = $_POST['act_place'];
$gg_drive = $_POST['gg_drive'];
$infor_name = $_POST['infor_name'];
$infor_position = $_POST['infor_position'];
$infor_belong = $_POST['infor_belong'];
$infor_tel = $_POST['infor_tel'];
$infor_phone = $_POST['infor_phone'];
$infor_email = $_POST['infor_email'];
$infor_line = $_POST['infor_line'];

$insertSql = "INSERT INTO activity(mouid, dates_tr, ag_id, op, typeAct_no, typeAct_custom, act_name, act_details, act_dateStart, act_dateEnd, act_place, gg_drive, infor) VALUES('".$mouid."','".$dates_tr."','".$ag_id."','".$op_name.",".$op_position.",".$op_tel.",".$op_phone.",".$op_email.",".$op_line.",".$op_faculty.",".$op_programs."','".$typeAct_no."','".$typeAct_custom."','".$act_name."','".$act_details."','".$act_dateStart."','".$act_dateEnd."','".$act_place."','".$gg_drive."','".$infor_name.",".$infor_position.",".$infor_belong.",".$infor_tel.",".$infor_phone.",".$infor_email.",".$infor_line."')";
$excute = mysqli_query($conn,$insertSql);
if ($excute) {
    $last_id = $conn->insert_id;
    header("location:activityDB.php");
}else {
    echo '<script
    alert("เพิ่มข้อมูลกิจกรรมไม่สำเร็จ");
    window.history.back();<script>';
}
?>