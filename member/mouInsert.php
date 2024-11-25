<?php 
require_once '../database/connect.php';
$dates_tr = $_POST['dates_tr'];
$deptNameCo = $_POST['deptNameCo'];
$Mo_type = $_POST['Mo_type'];
$department = $_POST['department'];
$deptType = $_POST['deptType'];
$depAddress = $_POST['depAddress'];
$time_mou = $_POST['time_mou'];
$CountyName = $_POST['CountyName'];
$nameMou = $_POST['nameMou'];
$dateStart = $_POST['dateStart'];
$dateExpired = $_POST['dateExpired'];
$deptAciton = $_POST['deptAciton'];
$signRmuti = $_POST['signRmuti'];
$signRmutiWitness = $_POST['signRmutiWitness'];
$signCo = $_POST['signCo'];
$signCoWitness = $_POST['signCoWitness'];
$objDesc = $_POST['objDesc'];
$infor_name = $_POST['infor_name'];
$infor_position = $_POST['infor_position'];
$infor_belong = $_POST['infor_belong'];
$infor_tel = $_POST['infor_tel'];
$infor_phone = $_POST['infor_phone'];
$infor_email = $_POST['infor_email'];
$infor_line = $_POST['infor_line'];
$renewal = $_POST['renewal'];
$renewaltime = $_POST['renewaltime'];
$ag_id = $_POST['ag_id'];
$gg_drive = $_POST['gg_drive'];
$goal_id = $_POST['goal_id'];

$goal_option = implode(",",$goal_id);

$upload = $_FILES['file_path'];

if ($upload['name'] != '') {
    $path = "../document/mo_pdf/";
    $fileType = strtolower(pathinfo($upload['name'],PATHINFO_EXTENSION));
    $allowedTypes = array("pdf");

    if (!in_array($fileType, $allowedTypes)) {
        echo "ขออภัย เฉพาะไฟล์ PDF เท่านั้น <br>";
        exit();
    }

    $newfilename = $upload['name'];
    $path_copy = $path . $newfilename;
    $path_link = $newfilename;

    // ตรวจสอบว่ามีไฟล์ชื่อเดียวกันอยู่หรือไม่
    if (file_exists($path_copy)) {
        echo "<script type='text/javascript'>";
        echo "alert('Error: File already exists!');";
        echo "window.location = 'mouSystem.php'; ";
        echo "</script>";
        exit();
    }

    // อัปโหลดไฟล์ลงในโฟลเดอร์
    move_uploaded_file($upload['tmp_name'], $path_copy);
}

$insertSql = "INSERT INTO mou(dates_tr, deptNameCo, Mo_type, department, deptType, depAddress, time_mou, CountyName, nameMou, dateStart, dateExpired, deptAciton, signRmuti, signRmutiWitness, signCo, signCoWitness, objDesc, userDesc, renewal, renewaltime, ag_id, file_path, gg_drive, goal_id) VALUES('".$dates_tr."','".$deptNameCo."','".$Mo_type."','".$department."','".$deptType."','".$depAddress."','".$time_mou."','".$CountyName."','".$nameMou."','".$dateStart."','".$dateExpired."','".$deptAciton."','".$signRmuti."','".$signRmutiWitness."','".$signCo."','".$signCoWitness."','".$objDesc."','".$infor_name.",".$infor_position.",".$infor_belong.",".$infor_tel.",".$infor_phone.",".$infor_email.",".$infor_line."','".$renewal."','".$renewaltime."','".$ag_id."','".$path_link."','".$gg_drive."','".$goal_option."')";
$excute = mysqli_query($conn,$insertSql);
// ตรวจสอบผลลัพธ์และแสดงข้อความ
if ($excute) {
    echo "<script type='text/javascript'>";
    echo "alert('Upload File Successfully');";
    echo "window.location = 'mouDB.php'; ";
    echo "</script>";
} else {
    echo "<script type='text/javascript'>";
    echo "alert('Error: Please try again');";
    echo "window.location = 'mouSystem.php'; ";
    echo "</script>";
}
?>