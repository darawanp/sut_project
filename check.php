<?php
    session_start();

    require_once 'database/connect.php';
    $sql = "SELECT * FROM user WHERE username ='".$_POST['username']."' AND password='".$_POST['password']."'";
    
    $result = mysqli_query($conn, $sql);
    $numrow = mysqli_num_rows($result);
    $row = mysqli_fetch_array($result);

    if ($numrow==0) {
        echo 'ไม่สามารถ Login ได้! กรุณาตรวจสอบ Username และ Password อีกครั้ง';
        header("Location:login.php?check.php=false");
    }else{
        if ($row['user_type'] == 1) {
            header("Location:admin/index_admin.php");
        }else{
            header("Location:member/index.php");
        }
    }

    $sqlSelect = "SELECT * FROM user u INNER JOIN agency_university ag WHERE u.ag_id=ag.ag_id AND username ='".$_POST['username']."' AND password='".$_POST['password']."'";
    $result2 = mysqli_query($conn, $sqlSelect);
    $row2 = mysqli_fetch_array($result2);
    $statusList = array("1"=>"มทร.อีสาน", "2"=> "มทร.ขอนแก่น", "3"=>"มทร.สกลนคร", "4"=>"มทร.สุรินทร์");

    $_SESSION['login']=$row['user_id'];
    $_SESSION['name']=$row['name'];
    $_SESSION['lastname']=$row['lastname'];
    $_SESSION['ag_id']=$row2['ag_id'];
    $_SESSION['ag_img']=$row2['agency_img'];
    $_SESSION['agency']=$row2['agencyname_thai'];
    $_SESSION['campus']=$statusList[$row2['campus']] .'   /    '. $row2['agencyname_thai'];
    $_SESSION['campus2']=$statusList[$row2['campus']];
    $_SESSION['agency_name']=$row2['agencyname_thai'];
    $_SESSION['user_type']=$row['user_type'];
    $_SESSION['username']=$row['username'];
?>