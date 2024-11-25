<?php
require_once '../database/connect.php';
$QA_no = $_POST['QA_no'];
$question = $_POST['question'];
$answer = $_POST['answer'];

$insertSql = "INSERT INTO qa(QA_no, question, answer) VALUES('".$QA_no."','".$question."','".$answer."')";
$excute = mysqli_query($conn,$insertSql);
if ($excute) {
    $last_id = $conn->insert_id;
    header("location:qa.php");
}else {
    echo '<script
    alert("เพิ่มข้อมูลหน่วยงานไม่สำเร็จ");
    window.history.back();<script>';
}
?>