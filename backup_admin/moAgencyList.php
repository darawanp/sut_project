<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>บันทึกการลงนามทั้งหมด - Admin Management</title>
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
    <?php include("menu_admin.php");
    $sql = "SELECT * FROM agency_university WHERE ag_id='" . $_GET['ag_id'] . "'";
    $query = mysqli_query($conn, $sql);
    $agen = mysqli_fetch_assoc($query)
        ?>
    <main id="main" class="main">
        <div class="pagetitle text-center">
            <h2>บันทึกการลงนาม</h2>
            <nav class="d-flex justify-content-center">
                <ol class="breadcrumb mt-3">
                    <li class="breadcrumb-item"><a href="index_admin.php">หน้าแรก</a></li>
                    <li class="breadcrumb-item"><a href="mouList.php">หน่วยงานในมหาวิทยาลัยทั้งหมด</a></li>
                    <li class="breadcrumb-item"><?php echo $agen['agencyname_thai'] ?></li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-site d-flex align-items-center">
                    <div class="d-flex mt-3 mb-3">
                        <h5 class="card-title me-3 col-lg-2">ค้นหา :</h5>
                        <input type="text" class="form-control col-lg-7" name="search"
                            placeholder="ค้นหาชื่อบันทึกความร่วมมือ">
                    </div>
                    <a href="mouSystem.php" class="ms-auto">
                        <button class="btn btn-primary btn-round me-2">
                            <i class="card-icon bi bi-clipboard2-plus-fill me-1"></i>
                            เพิ่มบันทึกการลงนาม
                        </button>
                    </a>
                </div>

                <?php function DateThai($strDate)
                {
                    $strYear = date("Y", strtotime($strDate)) + 543;
                    $strMonth = date("n", strtotime($strDate));
                    $strDay = date("j", strtotime($strDate));
                    $strMonthCut = array("", "มกราคม.", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
                    $strMonthThai = $strMonthCut[$strMonth];
                    return "$strDay $strMonthThai $strYear";
                } ?>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>ชื่อบันทึกความร่วมมือ</th>
                                    <th>หน่วยงานที่ร่วมมือ</th>
                                    <th>ประเภท</th>
                                    <th>วันที่ลงนาม</th>
                                    <th>ระยะเวลา</th>
                                    <th class="text-center">ไฟล์การลงนาม</th>
                                    <th class="text-center"><i class="bi bi-gear-fill"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM mou WHERE ag_id='" . $agen['ag_id'] . "'";
                                $result = mysqli_query($conn, $sql);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    $i=1;
                                    while ($row = mysqli_fetch_assoc($result)) { ?>
                                        <tr>
                                            <td><?php echo $i++ ?></td>
                                            <td><?php echo $row['nameMou'] ?></td>
                                            <td><?php echo $row['deptNameCo'] ?></td>
                                            <td><?php
                                                if ($row['Mo_type']==1) {
                                                    echo '<span class="badge rounded-pill bg-secondary" style="font-size:14px; font-weight:400;">MOI</span>';
                                                } elseif ($row['Mo_type']==2) {
                                                    echo '<span class="badge rounded-pill bg-warning" style="font-size:14px; font-weight:400;">MOU</span>';
                                                } elseif ($row['Mo_type']==3) {
                                                    echo '<span class="badge rounded-pill bg-info" style="font-size:14px; font-weight:400;">MOA</span>';
                                                }
                                            ?>
                                            </td>
                                            <td><?php echo DateThai($row['dateStart']) ?></td>
                                            <td><?php echo $row['time_mou'] ?> ปี</td>
                                            <td class="text-center"><a href="../document/mo_pdf/<?php echo $row['file_path'] ?>" target="_blank" class="btn btn-danger"><i class="bi bi-filetype-pdf me-2"></i>PDF</a></td>
                                            <td class="text-center">
                                                <a href="" class="btn btn-primary"><i class="bi bi-eye-fill"></i></a>
                                            </td>
                                        </tr>
                                    <?php }
                                } else {
                                    echo '<tr><td colspan="8" align="center">ไม่พบข้อมูล</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>






    <?php include("footer_admin.php") ?>
</body>