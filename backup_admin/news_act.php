<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>ข่าวกิจกรรม - Admin Management</title>
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
    <main id="main" class="main" style="margin-top: 90px;">

        <div class="pagetitle text-center">
            <h2>ข่าว</h2>
            <nav class="d-flex justify-content-center">
                <ol class="breadcrumb mt-3">
                    <li class="breadcrumb-item"><a href="index_admin.php">หน้าแรก</a></li>
                    <li class="breadcrumb-item"><a href="news_act.php">ข่าวกิจกรรม</a></li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-site d-flex align-items-center">
                    <h5 class="card-title me-3">ข่าวกิจกรรม   |</h5>
                    <!-- ฟอร์มการค้นหา -->
                    <form name="form1" action="news_act.php" method="get" class="form-inline">
                        <div class="d-flex mt-3 mb-3">
                            <input type="text" class="form-control col-lg-7" name="search_news" placeholder="ค้นหาชื่อข่าว">
                            <!-- ส่งค่า news_type ผ่านฟอร์ม -->
                            <div class="col-lg-1 col-xs-4 offset-md-1">    
                                <input type="submit" class="btn btn-success" value="ค้นหา">
                            </div>
                        </div>
                    </form>
                    <a href="newsCreate.php" class="ms-auto">
                        <button class="btn btn-primary btn-round me-2">
                            <i class="card-icon bi bi-folder-plus me-1"></i>
                            เพิ่มข่าว
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
                } 
                
                // ตรวจสอบว่ามีการค้นหาหรือไม่
                $search_query = "";
                if (isset($_GET['search_news']) && !empty($_GET['search_news'])) {
                    $search_query = mysqli_real_escape_string($conn, $_GET['search_news']);
                    $sql = "SELECT * FROM news WHERE news_type=2 
                            AND news_title LIKE '%" . $search_query . "%'";
                } else {
                    // หากไม่มีการค้นหา ให้แสดงข้อมูลทั้งหมด
                    $sql = "SELECT * FROM news WHERE news_type=2";
                }

                $result = mysqli_query($conn, $sql);
                
                ?>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th>ชื่อ</th>
                                    <th>นามสกุล</th>
                                    <th>ประเภทผู้ใช้</th>
                                    <th>ฝ่ายงาน</th>
                                    <th>คาบทั้งหมด</th>
                                    <th class="text-center">สถานะ</th>
                                    <th class="text-center"><i class="bi bi-gear-fill"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result && mysqli_num_rows($result) > 0) {

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<tr>
                                            <td class="text-center" hidden>' . $row['news_no'] . '</td>
                                            
                                            <td>' . DateThai($row['news_date']) . '</td>
                                            <td>' . $row['news_title'] . '</td>
                                            <td class="text-center">
                                                <a href="viewer_news.php?news_no=' . $row['news_no'] . '" class="btn btn-primary"><i class="bi bi-eye-fill"></i> </a>
                                                <a href="newsEdit.php?news_no=' . $row['news_no'] . '&news_img=' . urlencode($row['news_img']) . '" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a><br>
                                                <a href="newsDelete.php?news_no=' . $row['news_no'] . '" class="btn btn-danger" onclick="return confirm(\'คุณแน่ใจหรือว่าต้องการลบข้อมูลนี้?\')"><i class="bi bi-trash3-fill"></i> </a>
                                            </td>
                                        </tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="6" align="center">ไม่พบข้อมูล</td></tr>';
                                }
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

</body>