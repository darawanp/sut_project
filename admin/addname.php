<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>บุคลากร - Admin Management</title>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php include("menu_admin.php") ?>
    <main id="main" class="main" style="margin-top: 90px;">

        <div class="pagetitle text-center">
            <h2>รายชื่อกรรมการคุมสอบ</h2>
            <nav class="d-flex justify-content-center">
                <ol class="breadcrumb mt-3">
                    <li class="breadcrumb-item"><a href="index_admin.php">หน้าแรก</a></li>
                    <li class="breadcrumb-item"><a href="people.php">บุคลากร</a></li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-site d-flex align-items-center">
                    <h5 class="card-title">รายชื่อกรรมการคุมสอบ</h5>
                    <a href="peopleCreate.php" class="ms-auto">
                        <button class="btn btn-primary btn-round me-2">
                            <i class="card-icon bi bi-person-fill-up me-1"></i>
                            เพิ่มรายชื่อกรรมการคุมสอบ
                        </button>
                    </a>
                </div>

                <div class="card-body">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            <input type="checkbox" id="selectAll" onclick="toggleAll(this)">
                                        </th>
                                        <th class="text-center">ลำดับ</th>
                                        <th class="text-center">รหัสพนักงาน</th>
                                        <th class="text-center">ชื่อ-นามสกุล</th>
                                        <th class="text-center">จำนวนคาบที่มี</th>
                                        <th class="text-center">เพิ่มจำนวนคาบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // ดึงข้อมูลจากตาราง user
                                    $sql = "SELECT personal_id, name, lastname, amout_hour FROM user ORDER BY amout_hour ASC";
                                    $result = mysqli_query($conn, $sql);
                                    $numrow = mysqli_num_rows($result);

                                    if ($numrow > 0) {
                                        $i = 1;
                                        while ($row = mysqli_fetch_assoc($result)) { ?>
                                            <tr>
                                                <td class="text-center">
                                                    <input type="checkbox" class="recordCheckbox" value="<?php echo $row['personal_id']; ?>">
                                                </td>
                                                <td class="text-center"><?php echo $i++; ?></td>
                                                <td class="text-center"><?php echo $row['personal_id']; ?></td>
                                                <td><?php echo $row['name'] . ' ' . $row['lastname']; ?></td>
                                                <td class="text-center"><?php echo $row['amout_hour']; ?></td>
                                                <td class="text-center">
                                                    <input type="number" class="form-control text-center" id="hours-<?php echo $row['personal_id']; ?>"
                                                        placeholder="เพิ่มจำนวนคาบ">
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-success btn-sm" onclick="updateHours('<?php echo $row['personal_id']; ?>')">
                                                        บันทึก
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php }
                                    } else { ?>
                                        <tr>
                                            <td colspan="7" class="text-center">ไม่มีข้อมูล</td>
                                        </tr>
                                    <?php }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </section>
    </main>
    <?php
    include("footer_admin.php")
    ?>
    <script>
        function toggleAll(source) {
            const checkboxes = document.querySelectorAll('.recordCheckbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = source.checked;
            });
        }

        function updateHours(personalId) {
            const hoursInput = document.getElementById(`hours-${personalId}`);
            const addedHours = hoursInput.value;

            if (addedHours === "" || isNaN(addedHours) || addedHours < 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'ข้อผิดพลาด',
                    text: 'กรุณากรอกจำนวนคาบที่ถูกต้อง',
                    timer: 1000,
                    showConfirmButton: false
                });
                return;
            }

            // ส่งข้อมูลผ่าน AJAX
            fetch('update_hours.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        personal_id: personalId,
                        added_hours: addedHours
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'บันทึกสำเร็จ',
                            text: 'ข้อมูลถูกบันทึกเรียบร้อยแล้ว',
                            timer: 1000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.reload(); // รีเฟรชหน้า
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: data.message,
                            timer: 1000,
                            showConfirmButton: false
                        });
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    Swal.fire({
                        icon: 'error',
                        title: 'ข้อผิดพลาด',
                        text: 'เกิดข้อผิดพลาดในการบันทึกข้อมูล',
                        timer: 1000,
                        showConfirmButton: false
                    });
                });
        }
    </script>

</body>