<?php
require_once '../database/connect.php';

// ดึงข้อมูลประเภทการสอบที่มี exam_type_id = 2
$sql_exam_types = "SELECT exam_type_id, exam_types_name FROM exam_types WHERE exam_type_id = 1";
$result_exam_types = $conn->query($sql_exam_types);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>เพิ่มข้อมูลวันคุมสอบ - Admin Management</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="../assets/img/RMUTI.png" rel="icon">
    <link href="../assets/img/RMUTI2.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" crossorigin rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="../assets/css/style.css" rel="stylesheet">

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.1/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body>
    <?php include("menu_admin.php") ?>

    <main id="main" class="main">
        <div class="pagetitle text-center">
            <h2>จัดการข้อมูลวันคุมสอบ กลางภาค</h2>
            <nav class="d-flex justify-content-center">
                <ol class="breadcrumb mt-3">
                    <li class="breadcrumb-item"><a href="index_admin.php">หน้าแรก</a></li>
                    <li class="breadcrumb-item"><a href="examMidterm.php">จัดการข้อมูลวันคุมสอบ กลางภาค</a></li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="col-12">
                <div class="card">
                    <div class="card-site">
                        <h5 class="card-title text-center">เพิ่มข้อมูลวันคุมสอบใหม่</h5>
                    </div>

                    <div class="card-body">
                        <form name="examScheduleAdd" action="examInsertMidterm.php" method="POST">
                            <div class="form">
                                <div class="row mb-4 g-3">
                                    <label class="col-md-4 col-lg-3 col-form-label">เลือกวันสอบ</label>
                                    <div class="col-md-8 col-lg-9 mb-2">
                                        <input name="exam_date" type="date" class="form-control" placeholder="เลือกวันสอบ">
                                    </div>
                                </div>

                                <div class="row mb-4 g-3">
                                    <label class="col-md-4 col-lg-3 col-form-label">ช่วงเวลา</label>
                                    <div class="col-md-8 col-lg-9 mb-2">
                                        <select name="exam_time" class="form-select">
                                            <option selected>เลือกเวลา</option>
                                            <option value="9:00-11:00">9:00 - 11:00</option>
                                            <option value="13:00-16:00">13:00 - 16:00</option>
                                            <option value="16:00-19:30">16:00 - 19:30</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-4 g-3">
                                    <label class="col-md-4 col-lg-3 col-form-label">จำนวนคนคุมสอบ</label>
                                    <div class="col-md-8 col-lg-9 mb-2">
                                        <input name="num_proctors" type="number" class="form-control" placeholder="จำนวนคนคุมสอบ">
                                    </div>
                                </div>

                                <div class="row mb-4 g-3" style="display: none;">
                                    <label class="col-md-4 col-lg-3 col-form-label">ประเภทการสอบ</label>
                                    <div class="col-md-8 col-lg-9 mb-2">
                                        <select name="exam_type" class="form-select">
                                            <!-- <?php while ($row = $result_exam_types->fetch_assoc()): ?> ตรวจสอบว่าไอดีที่ดึงมามีค่าเป็น 1 = สอบกลางภาค ถ้าใช้ให้ทำการแสดงตัวเลือกออกมา  -->
                                                <option value="<?= $row['exam_type_id'] ?>" 
                                                    <?= $row['exam_types_name'] == 'สอบกลางภาค' ? 'selected' : '' ?>>
                                                    <?= $row['exam_types_name'] ?>
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success">บันทึก</button>
                                    <button type="reset" class="btn btn-warning">ล้างข้อมูล</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.1/dist/sweetalert2.all.min.js"></script>
    <script>
        <?php if (isset($_GET['status'])): ?>
            let status = "<?php echo $_GET['status']; ?>";
            if (status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'บันทึกข้อมูลสำเร็จ',
                    text: 'ข้อมูลวันคุมสอบถูกบันทึกเรียบร้อยแล้ว',
                    timer: 1000, // แสดง 1 วินาที
                    showConfirmButton: false, // ซ่อนปุ่ม "ตกลง"
                }).then(() => {
                    // หลังจากแสดงข้อความเสร็จ ให้ไปที่หน้า examSchedule.php
                    window.location.href = "examSchedule.php";
                });
            } else if (status === 'error') {
                Swal.fire({
                    icon: 'error',
                    title: 'บันทึกข้อมูลไม่สำเร็จ',
                    text: 'เกิดข้อผิดพลาดในการบันทึกข้อมูล',
                    timer: 1000,
                    showConfirmButton: false,
                }).then(() => {
                    window.location.href = "examMidterm.php";
                });
            } else if (status === 'warning') {
                Swal.fire({
                    icon: 'warning',
                    title: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                    text: 'โปรดตรวจสอบข้อมูลที่กรอกให้ครบถ้วน',
                    timer: 1000,
                    showConfirmButton: false,
                }).then(() => {
                    window.location.href = "examMidterm.php";
                });
            }
        <?php endif; ?>
    </script>
    <?php include("footer_admin.php") ?>
</body>

</html>