<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>ข้อมูลผู้ใช้ - Admin Management</title>
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
            <h2>จัดการข้อมูลบัญชีผู้ใช้</h2>
            <nav class="d-flex justify-content-center">
                <ol class="breadcrumb mt-3">
                    <li class="breadcrumb-item"><a href="index_admin.php">หน้าแรก</a></li>
                    <li class="breadcrumb-item"><a href="profile.php">จัดการข้อมูลบัญชีผู้ใช้</a></li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="col-12">
                <div class="card">
                    <div class="card-site d-flex align-items-center">
                        <h5 class="card-title me-3">บัญชีผู้ใช้ทั้งหมด |</h5>
                        <form name="form1" action="profile.php" method="get" class="form-inline">
                            <div class="d-flex mt-3 mb-3">
                                <input type="text" class="form-control col-lg-7" name="search_profile"
                                    placeholder="ค้นหาชื่อ หรือฝ่ายงาน">
                                <!-- ส่งค่า news_type ผ่านฟอร์ม -->
                                <div class="col-lg-1 col-xs-4 offset-md-1">
                                    <input type="submit" class="btn btn-success" value="ค้นหา">
                                </div>
                            </div>
                        </form>
                        <a href="userCreate.php" class="ms-auto">
                            <button class="btn btn-primary btn-round me-2">
                                <i class="card-icon bi bi-person-plus-fill me-1"></i>
                                เพิ่มผู้ใช้
                            </button>
                        </a>
                    </div>

                    <div class="card-body">
                        <?php
                        // ตรวจสอบว่ามีการค้นหาหรือไม่
                        $search_query = isset($_GET['search_profile']) ? mysqli_real_escape_string($conn, $_GET['search_profile']) : '';

                        // สร้าง SQL query
                        $sql = "SELECT * 
                                FROM user 
                                INNER JOIN agency_university ag ON user.ag_id = ag.ag_id 
                                WHERE user.name LIKE '%" . $search_query . "%'  
                                OR ag.agencyname_thai LIKE '%" . $search_query . "%' 
                                ORDER BY user.user_type ASC";

                        $result = mysqli_query($conn, $sql);
                        $numrow = mysqli_num_rows($result);

                        ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">ลำดับ</th>
                                        <th>ชื่อ</th>
                                        <th>นามสกุล</th>
                                        <th>ประเภทผู้ใช้</th>
                                        <th>ฝ่ายงาน</th>
                                        <th class="text-center">สถานะ</th>
                                        <th class="text-center">จัดการ</th>
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
                                                <td hidden><?php echo $row['user_id']; ?></td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['lastname']; ?></td>

                                                <?php if ($row['user_type'] == 1) {
                                                    echo "<td><span class='badge rounded-pill bg-secondary' style='font-size:14px; font-weight:400;'>แอดมิน</span></td>";
                                                } elseif ($row['user_type'] == 2) {
                                                    echo "<td><span class='badge rounded-pill bg-info' style='font-size:14px; font-weight:400;'>ผู้ใช้งานระบบ</span></td>";
                                                } ?>


                                                <td><?php echo $row['agencyname_thai']; ?></td>

                                                <?php if ($row['status'] == 0) {
                                                    echo "<td class='text-center'><span class='badge rounded-pill bg-secondary' style='font-size:14px; font-weight:400;'>ไม่อนุญาตให้เข้าใช้งาน</span></td>";
                                                } elseif ($row['status'] == 1) {
                                                    echo "<td class='text-center'><span class='badge rounded-pill bg-success' style='font-size:14px; font-weight:400;'>อนุญาตให้เข้าใช้งาน</span></td>";
                                                } ?>

                                                <td class="text-center">
                                                    <a href="<?php echo 'profileEdit.php?user_id=' . $row['user_id']; ?>"
                                                        class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
                                                    <a href="<?php echo 'userDelete.php?user_id=' . $row['user_id']; ?>"
                                                        class="btn btn-danger"><i class="bi bi-trash3-fill"></i></a>
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
    include("footer_admin.php")
        ?>

</body>