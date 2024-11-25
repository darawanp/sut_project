<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>หน่วยงานใน มทร.อีสาน - Admin Management</title>
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
            <h2>หน่วยงาน</h2>
            <nav class="d-flex justify-content-center">
                <ol class="breadcrumb mt-3">
                    <li class="breadcrumb-item"><a href="index_admin.php">หน้าแรก</a></li>
                    <li class="breadcrumb-item"><a href="agency.php">หน่วยงาน</a></li>
                </ol>
            </nav>
        </div>

        <section class="section">

            <div class="col-lg- col-12">
                <div class="card">
                    <div class="card-site d-flex align-items-center">
                        <h5 class="card-title me-3">หน่วยงานทั้งหมด |</h5>
                        <form name="form1" action="agency.php" method="get" class="form-inline">
                            <div class="d-flex mt-3 mb-3">
                                <input type="text" class="form-control col-lg-7" name="search_agency_university"
                                    placeholder="ค้นหาชื่อหน่วยงานหรืออักษรย่อ(TH/EN)">
                                <!-- ส่งค่า news_type ผ่านฟอร์ม -->
                                <div class="col-lg-1 col-xs-4 offset-md-1">
                                    <input type="submit" class="btn btn-success" value="ค้นหา">
                                </div>
                            </div>
                        </form>
                        <a href="agencyCreate.php" class="ms-auto">
                            <button class="btn btn-primary btn-round me-2">
                                <i class="card-icon bi bi-plus-lg me-1"></i>
                                เพิ่มหน่วยงาน
                            </button>
                        </a>
                    </div>
                    <div class="card-body">
                        <?php
                        // ตรวจสอบว่ามีการค้นหาหรือไม่
                        $search_query = isset($_GET['search_agency_university']) ? mysqli_real_escape_string($conn, $_GET['search_agency_university']) : '';

                        // ปรับ query โดยใช้ OR เพื่อให้การค้นหาครอบคลุมมากขึ้น และวาง ORDER BY ไว้หลัง WHERE
                        $sqlSelect = "SELECT * FROM agency_university ag
                  WHERE ag.agencyname_thai LIKE '%$search_query%'  
                  OR ag.agencyname_eng LIKE '%$search_query%'
                  OR ag.abbreviation_thai LIKE '%$search_query%'
                  OR ag.abbreviation_eng LIKE '%$search_query%'
                  ORDER BY ag.campus ASC;";

                        // ตรวจสอบการเชื่อมต่อฐานข้อมูลและรันคำสั่ง SQL
                        $result = mysqli_query($conn, $sqlSelect);

                        // ตรวจสอบว่ามีผลลัพธ์ที่ถูกต้องหรือไม่
                        if ($result) {
                            $numrow = mysqli_num_rows($result);
                        } else {
                            // แสดงข้อผิดพลาดในกรณีที่ SQL ไม่ถูกต้อง
                            echo "Error in query: " . mysqli_error($conn);
                            $numrow = 0; // กำหนดให้ $numrow เป็น 0 ในกรณีที่มีข้อผิดพลาด
                        }
                        ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">ลำดับ</th>
                                        <th>อักษรย่อ</th>
                                        <th>ชื่อหน่วยงาน/มหาวิทยาลัย</th>
                                        <th>วิทยาเขต</th>
                                        <th class="text-center"><i class="bi bi-gear-fill"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($numrow > 0) {
                                        $i = 1;
                                        while ($row = mysqli_fetch_assoc($result)) { ?>
                                            <tr>
                                                <td class="text-center"><?php echo ($i++); ?></td>
                                                <td hidden><?php echo $row['ag_id']; ?></td>
                                                <td><?php echo $row['abbreviation_thai']; ?></td>
                                                <td><?php echo $row['agencyname_thai']; ?></td>

                                                <?php if ($row['campus'] == 1) {
                                                    echo "<td>ศูนย์กลางนครราชสีมา</td>";
                                                } elseif ($row['campus'] == 2) {
                                                    echo "<td>วิทยาเขตขอนแก่น</td>";
                                                } elseif ($row['campus'] == 3) {
                                                    echo "<td>วิทยาเขตสกลนคร</td>";
                                                } elseif ($row['campus'] == 4) {
                                                    echo "<td>วิทยาเขตสุรินทร์</td>";
                                                } ?>

                                                <td class="text-center">
                                                    <a href="<?php echo 'agencyEdit.php?ag_id=' . $row['ag_id']; ?>"
                                                        class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
                                                </td>
                                            </tr>
                                        <?php }
                                    }
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
    include("footer_admin.php");
    ?>
</body>