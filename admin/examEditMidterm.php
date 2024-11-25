<?php
require_once '../database/connect.php';

if (isset($_GET['id'])) {
    $exam_id = $_GET['id'];
    
    // ดึงข้อมูลจากตาราง exam_schedule ที่ต้องการแก้ไข
    $sql = "SELECT * FROM exam_schedule WHERE exam_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $exam_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    // ดึงประเภทการสอบ
    $sql_exam_types = "SELECT exam_type_id, exam_types_name FROM exam_types";
    $result_exam_types = $conn->query($sql_exam_types);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $exam_date = $_POST['exam_date'];
    $exam_time = $_POST['exam_time'];
    $num_proctors = $_POST['num_proctors'];
    $exam_type = $_POST['exam_type'];

    // ตรวจสอบข้อมูลก่อนการอัพเดต
    if ($exam_date && $exam_time && $num_proctors && $exam_type) {
        $sql_update = "UPDATE exam_schedule SET exam_date = ?, exam_time = ?, num_proctors = ?, exam_type_id = ? WHERE exam_id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ssiii", $exam_date, $exam_time, $num_proctors, $exam_type, $exam_id);

        if ($stmt_update->execute()) {
            echo "<script>
                setTimeout(() => {
                    Swal.fire({
                        icon: 'success',
                        title: 'อัพเดตข้อมูลสำเร็จ!',
                        text: 'ระบบจะเปลี่ยนหน้าอัตโนมัติ...',
                        timer: 1000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = 'examSchedule.php';
                    });
                }, 100);
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด!',
                    text: 'ไม่สามารถอัพเดตข้อมูลได้ โปรดลองอีกครั้ง',
                    timer: 1000,
                    showConfirmButton: false
                });
            </script>";
        }
    } else {
        echo "<script>
            Swal.fire({
                icon: 'warning',
                title: 'ข้อมูลไม่ครบถ้วน!',
                text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                timer: 1000,
                showConfirmButton: false
            });
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลวันคุมสอบ - Admin Management</title>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Favicons -->
    <link href="../assets/img/RMUTI.png" rel="icon">
    <link href="../assets/img/RMUTI2.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="../assets/css/style.css" rel="stylesheet">
</head>

<body>
    <?php include("menu_admin.php") ?>

    <main id="main" class="main">
        <div class="pagetitle text-center">
            <h2>แก้ไขข้อมูลวันคุมสอบ</h2>
            <nav class="d-flex justify-content-center">
                <ol class="breadcrumb mt-3">
                    <li class="breadcrumb-item"><a href="index_admin.php">หน้าแรก</a></li>
                    <li class="breadcrumb-item"><a href="examMidterm.php">จัดการข้อมูลวันคุมสอบ</a></li>
                    <li class="breadcrumb-item active">แก้ไขข้อมูลวันคุมสอบ</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="col-12">
                <div class="card">
                    <div class="card-site">
                        <h5 class="card-title text-center">แก้ไขข้อมูลวันคุมสอบ</h5>
                    </div>

                    <div class="card-body">
                        <form method="POST">
                            <div class="form">
                                <div class="row mb-4 g-3">
                                    <label class="col-md-4 col-lg-3 col-form-label">เลือกวันสอบ</label>
                                    <div class="col-md-8 col-lg-9 mb-2">
                                        <input name="exam_date" type="date" class="form-control" value="<?php echo $row['exam_date']; ?>" required>
                                    </div>
                                </div>

                                <div class="row mb-4 g-3">
                                    <label class="col-md-4 col-lg-3 col-form-label">ช่วงเวลา</label>
                                    <div class="col-md-8 col-lg-9 mb-2">
                                        <select name="exam_time" class="form-select" required>
                                            <option value="9:00-12:00" <?php echo $row['exam_time'] == '9:00-11:00' ? 'selected' : ''; ?>>9:00 - 11:00</option>
                                            <option value="13:00-16:00" <?php echo $row['exam_time'] == '13:00-16:00' ? 'selected' : ''; ?>>13:00 - 16:00</option>
                                            <option value="16:00-19:30" <?php echo $row['exam_time'] == '16:00-19:30' ? 'selected' : ''; ?>>16:00 - 19:30</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-4 g-3">
                                    <label class="col-md-4 col-lg-3 col-form-label">จำนวนคนคุมสอบ</label>
                                    <div class="col-md-8 col-lg-9 mb-2">
                                        <input name="num_proctors" type="number" class="form-control" value="<?php echo $row['num_proctors']; ?>" required>
                                    </div>
                                </div>

                                <div class="row mb-4 g-3" style="display: none;">
                                    <label class="col-md-4 col-lg-3 col-form-label">ประเภทการสอบ</label>
                                    <div class="col-md-8 col-lg-9 mb-2">
                                        <select name="exam_type" class="form-select" required>
                                            <?php while ($exam_type_row = $result_exam_types->fetch_assoc()): ?>
                                                <option value="<?= $exam_type_row['exam_type_id'] ?>" <?= $exam_type_row['exam_type_id'] == $row['exam_type_id'] ? 'selected' : '' ?>>
                                                    <?= $exam_type_row['exam_types_name'] ?>
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success">อัพเดตข้อมูล</button>
                                    <a href="examSchedule.php" class="btn btn-warning">ยกเลิก</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include("footer_admin.php") ?>
</body>

</html>
