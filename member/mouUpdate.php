<?php
require_once '../database/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mouid = intval($_POST['mouid']);
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
    $gg_drive = $_POST['gg_drive'];
    $old_file_path = $_POST['old_file_path'];
    $goal_id = $_POST['goal_id'];
    $goal_option = implode(",",$goal_id);

    // ตรวจสอบการอัปโหลดไฟล์ใหม่
    if (isset($_FILES['file_path']) && $_FILES['file_path']['error'] == UPLOAD_ERR_OK) {
        $file_path = '../document/mo_pdf/' . basename($_FILES['file_path']['name']); // เส้นทางที่ต้องการบันทึกไฟล์ใหม่
        move_uploaded_file($_FILES['file_path']['tmp_name'], $file_path); // อัปโหลดไฟล์ใหม่

        // หากมีการอัปโหลดไฟล์ใหม่ ให้อัปเดตฐานข้อมูล
        $sqlUpdate = "UPDATE mou SET deptNameCo = '" . $deptNameCo . "', Mo_type = '" . $Mo_type . "', department = '" . $department . "', deptType = '" . $deptType . "', depAddress = '" . $depAddress . "', time_mou = '" . $time_mou . "', CountyName = '" . $CountyName . "', nameMou = '" . $nameMou . "', dateStart = '" . $dateStart . "', dateExpired = '" . $dateExpired . "', signRmuti = '" . $signRmuti . "', signRmutiWitness = '" . $signRmutiWitness . "', signCo = '" . $signCo . "', signCoWitness = '" . $signCoWitness . "', objDesc = '" . $objDesc . "', userDesc = '".$infor_name.",".$infor_position.",".$infor_belong.",".$infor_tel.",".$infor_phone.",".$infor_email.",".$infor_line."', renewal = '".$renewal."', renewaltime = '".$renewaltime."', gg_drive = '".$gg_drive."', file_path = '".$file_path."', goal_id = '".$goal_option."' WHERE mouid = '".$mouid."'";
        $excute =mysqli_query($conn,$sqlUpdate);
    } else {
        // ถ้าไม่อัปโหลดไฟล์ใหม่ ให้ใช้ไฟล์เก่า
        $file_path = $old_file_path; // ใช้ไฟล์เก่า
        $sqlUpdate = "UPDATE mou SET deptNameCo = '" . $deptNameCo . "', Mo_type = '" . $Mo_type . "', department = '" . $department . "', deptType = '" . $deptType . "', depAddress = '" . $depAddress . "', time_mou = '" . $time_mou . "', CountyName = '" . $CountyName . "', nameMou = '" . $nameMou . "', dateStart = '" . $dateStart . "', dateExpired = '" . $dateExpired . "', signRmuti = '" . $signRmuti . "', signRmutiWitness = '" . $signRmutiWitness . "', signCo = '" . $signCo . "', signCoWitness = '" . $signCoWitness . "', objDesc = '" . $objDesc . "', userDesc = '".$infor_name.",".$infor_position.",".$infor_belong.",".$infor_tel.",".$infor_phone.",".$infor_email.",".$infor_line."', renewal = '".$renewal."', renewaltime = '".$renewaltime."', gg_drive = '".$gg_drive."', file_path = '".$file_path."', goal_id = '".$goal_option."' WHERE mouid = '".$mouid."'";
        $excute =mysqli_query($conn,$sqlUpdate);
    }

    // ทำการอัปเดตข้อมูลในฐานข้อมูล
    if ($excute) {
        echo "<script type='text/javascript'>";
        echo "alert('บันทึกข้อมูลสำเร็จ');";
        echo "window.location = 'mouDB.php'; ";
        echo "</script>";
    } else {
        // echo ": " . mysqli_error($conn);
        echo "<script type='text/javascript'>";
        echo "alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล');";
        echo "window.location = 'mouEdit.php'; ";
        echo "</script>";
    }
    
}

?>