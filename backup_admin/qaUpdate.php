<?php session_start();
require_once '../database/connect.php';
$question = $_POST['question'];
$answer = $_POST['answer'];
$QA_no = isset($_POST['QA_no']) ? $_POST['QA_no'] : null;
if ($QA_no) {
    $updateSql = "UPDATE qa SET question='".$question."', answer='".$answer."' WHERE QA_no='".$QA_no."'";
    $excute = mysqli_query($conn,$updateSql);
    if ($excute) {
        echo '<script>
           window.location.href="qa.php";
           </script>';
    }
}else {
    echo '<script>
    alert("ไม่พบข้อมูล");
    window.history.back();
    </script>';
}
?>