<?php
require_once '../database/connect.php';
$qa_username = $_POST['qa_username'];
$qa_email = $_POST['qa_email'];
$question = $_POST['question'];
$question_details = $_POST['question_details'];

$insertSql = "INSERT INTO message(qa_username, qa_email, question, question_details) VALUES('".$qa_username."','".$qa_email."','".$question."','".$question_details."')";
$excute = mysqli_query($conn,$insertSql);
if ($excute) {
    $last_id = $conn->insert_id;
    header("location:contact.php");
}else {
    echo '<script
    alert("เพิ่มข้อมูลไม่สำเร็จ");
    window.history.back();<script>';
}
?>