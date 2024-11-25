<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>รายละเอียดข่าว - Admin Management</title>
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

  <!-- SummerNote -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
</head>


<body>
    <?php include("menu_admin.php");

    // กำหนดค่าเริ่มต้นให้กับตัวแปรเพื่อป้องกันข้อผิดพลาด
    $news_title = $news_date = $news_type = $news_details = $news_img = "";
    $news_gallery = [];

    if (isset($_GET['news_no'])) {
        $news_no = $_GET['news_no'];
        $sql = "SELECT * FROM news WHERE news_no = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $news_no);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            // ข้อมูลข่าวที่ต้องการจะแสดง
            $news_title = $row['news_title'];
            $news_date = $row['news_date'];
            $news_type = $row['news_type'];
            $news_img = $row['news_img'];
            $news_details = $row['news_details'];
            $news_gallery = !empty($row['news_gallery']) ? explode(',', $row['news_gallery']) : []; // เช็คถ้า gallery มีค่า
        } else {
            echo "ไม่พบข่าวที่คุณค้นหา";
        }
    } else {
        echo "ไม่มีหมายเลขข่าวที่ถูกส่งมา";
    }

?>
    <main id="main" class="main" style="margin-top: 90px;">

        <div class="pagetitle text-center">
            <h2><?php echo htmlspecialchars($news_title); ?></h2>
            <nav class="d-flex justify-content-center">
                <ol class="breadcrumb mt-3">
                    <li class="breadcrumb-item"><a href="index-admin.php">หน้าแรก</a></li>
                    <li class="breadcrumb-item"><a href="news-admin.php">รวมข่าว</a></li>
                    <li class="breadcrumb-item active">รายละเอียดข่าว</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="card">
                <!-- <div class="align-items-center"> -->
                    <!-- <h5 class="card-title">รายละเอียดข่าว</h5> -->
                    <a href="newsEdit.php?news_no=<?php echo $_GET['news_no'] ?>" class="ms-auto">
                        <button class="btn btn-warning btn-round me-2">
                            <i class="bi bi-pencil-square"></i>
                            แก้ไข
                        </button>
                    </a>
                <!-- </div> -->

                <div class="card-body">
                    <!-- <h5 class="card-title">รายละเอียดข่าว</h5> -->

                    <p><strong>วันที่ลงข่าว: </strong><?php echo htmlspecialchars($news_date); ?></p>
                    <p><strong>หัวข้อข่าว: </strong><?php echo htmlspecialchars($news_title); ?></p>
                    <p><strong>ประเภทข่าว: </strong>
                    <?php          
                        if ($news_type == 1) {
                            echo "ข่าวประชาสัมพันธ์ทุน";
                        } else if ($news_type == 2) {
                            echo "ข่าวกิจกรรม";
                        } else {
                            echo "ไม่ระบุประเภทข่าว";
                        }
                    ?>
                    </p>

                    <h6>รูปภาพหลัก</h6>
                    <?php if (!empty($news_img)) { ?>
                        <div class="text-center mb-4">
                            <img src="../pic/newspicture/<?php echo htmlspecialchars($news_img); ?>" class="img-fluid img-thumbnail" alt="รูปภาพหลักของข่าว" style="max-width: 100%; height: auto;">
                        </div>
                    <?php } else { ?>
                        <p>ไม่มีรูปภาพหลัก</p>
                    <?php } ?>

                    <p><strong>รายละเอียดข่าว: </strong><?php echo nl2br(htmlspecialchars($news_details)); ?></p>

                    <h6>รูปภาพเพิ่มเติม</h6>
                    <div class="row">
                        <?php 
                        if (!empty($news_gallery)) {
                            foreach ($news_gallery as $image) {
                                echo '
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="card h-100">
                                        <img src="../pic/newspicture/'.htmlspecialchars(trim($image)).'" class="card-img-top img-thumbnail" alt="รูปภาพเพิ่มเติม" style="max-height: 200px; object-fit: cover;">
                                    </div>
                                </div>';
                            }
                        } else {
                            echo '<p>ไม่มีรูปภาพเพิ่มเติม</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <?php include("footer_admin.php"); ?>
</body>
