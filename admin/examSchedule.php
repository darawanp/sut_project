<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>บันทึกข้อมูลการคุมสอบ</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="../assets/img/RMUTI.png" rel="icon">
    <link href="../assets/img/RMUTI2.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" crossorigin rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap"
        rel="stylesheet">

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

    <!-- SummerNote -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
</head>

<body>
    <?php include("menu_admin.php") ?>
    <main id="main" class="main">

        <div class="pagetitle text-center">
            <h2>บันทึกข้อมูลการคุมสอบ</h2>
            <nav class="d-flex justify-content-center">
            </nav>
        </div>

        <section class="section">
            <div class="col-12">
                <div class="card">
                    <div class="card-site d-flex align-items-center">
                        <h5 class="card-title me-3">ข้อมูลการคุมสอบ</h5>
                        <a href="examMidterm.php" class="ms-auto">
                            <button class="btn btn-primary btn-round me-2">
                                <i class="card-icon bi bi-person-plus-fill me-1"></i>
                                สอบกลางภาค
                            </button>
                        </a>
                        <a href="examFinal.php">
                            <button class="btn btn-primary btn-round me-2">
                                <i class="card-icon bi bi-person-plus-fill me-1"></i>
                                สอบประจำภาค
                            </button>
                        </a>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">ลำดับ</th>
                                        <th>ประเภทการสอบ</th>
                                        <th>วันที่สอบ</th>
                                        <th>ช่วงเวลา</th>
                                        <th>จำนวนคนคุมสอบ</th>
                                        <th>วันที่แก้ไข</th>
                                        <th class="text-center">จัดการ</th> <!-- คอลัมน์จัดการ -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // ดึงข้อมูลจากตาราง exam_schedule และ exam_types
                                    $sql = "SELECT es.*, et.exam_types_name 
                                            FROM exam_schedule es
                                            LEFT JOIN exam_types et ON es.exam_type_id = et.exam_type_id
                                            ORDER BY es.updated_at ASC";
                                    $result = mysqli_query($conn, $sql);
                                    $numrow = mysqli_num_rows($result);

                                    if ($numrow > 0) {
                                        $i = 1;
                                        while ($row = mysqli_fetch_assoc($result)) { ?>
                                            <tr>
                                                <td class="text-center"><?php echo ($i++); ?></td>
                                                <td><?php echo $row['exam_types_name']; ?></td>
                                                <td><?php echo $row['exam_date']; ?></td>
                                                <td><?php echo $row['exam_time']; ?></td>
                                                <td><?php echo $row['num_proctors']; ?></td>
                                                <td><?php echo $row['updated_at']; ?></td>
                                                <td class="text-center">
                                                    <?php
                                                    // Determine the edit page based on exam type ดึงไทป์เนมมาตรวจสอบว่าเป็นสอบกลางภาคไหม ถ้าเป็นมิดเทอมแสดงมิดเทอม ถ้าเป็นไฟนอลแสดงหน้าแก้ไขไฟนอล
                                                    $editPage = ($row['exam_types_name'] == 'สอบกลางภาค') ? 'examEditMidterm.php' : 'examEditFinal.php';
                                                    ?>
                                                    <!-- Edit Button -->
                                                    <a href="<?php echo $editPage; ?>?id=<?php echo $row['exam_id']; ?>" class="btn btn-warning btn-sm">
                                                        <i class="bi bi-pencil-fill"></i> แก้ไข
                                                    </a>
                                                    <!-- Delete Button -->
                                                    <a href="javascript:void(0);" class="btn btn-danger btn-sm" onclick="confirmDelete('examDelete.php?id=<?php echo $row['exam_id']; ?>')">
                                                        <i class="bi bi-trash-fill"></i> ลบ
                                                    </a>
                                                </td>


                                            </tr>
                                        <?php }
                                    } else { ?>
                                        <tr>
                                            <td colspan="7" class="text-center">ไม่มีข้อมูลการคุมสอบ</td>
                                        </tr>
                                    <?php }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>
    <?php
    include("footer_admin.php")
    ?>
    <!-- เพิ่ม link สำหรับ SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // ฟังก์ชันยืนยันการลบ
        function confirmDelete(url) {
            Swal.fire({
                title: 'คุณต้องการลบข้อมูลนี้ใช่ไหม?',
                text: "ข้อมูลจะถูกลบถาวร!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    // ถ้าผู้ใช้กดตกลง ให้ทำการลบข้อมูลโดยการส่งคำขอไปยัง URL ที่ระบุ
                    window.location.href = url;
                }
            });
        }
        // ตรวจสอบค่าจาก URL หากมี parameter status
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');

        // ถ้าลบข้อมูลสำเร็จ
        if (status === 'error') {
            Swal.fire({
                title: 'ลบข้อมูลสำเร็จ!',
                text: 'ข้อมูลการคุมสอบถูกลบออกแล้ว.',
                icon: 'error',
                showConfirmButton: false, // ไม่ให้แสดงปุ่ม "ตกลง"
                timer: 1000, // ปิด popup อัตโนมัติหลังจาก 2 วินาที
                timerProgressBar: true // แสดง progress bar ขณะนับเวลา
            });
        }
        // ถ้ามีข้อผิดพลาดในการลบ
        else if (status === 'error') {
            Swal.fire({
                title: 'เกิดข้อผิดพลาด!',
                text: 'ไม่สามารถลบข้อมูลได้.',
                icon: 'error',
                showConfirmButton: false, // ไม่ให้แสดงปุ่ม "ตกลง"
                timer: 1000, // ปิด popup อัตโนมัติหลังจาก 2 วินาที
                timerProgressBar: true // แสดง progress bar ขณะนับเวลา
            });
        }
    </script>

</body>