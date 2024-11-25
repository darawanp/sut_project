<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>แก้ไขข่าว - Admin Management</title>
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
    <?php include("menu_admin.php") ?>
    <main id="main" class="main">
        <div class="pagetitle text-center">
            <h2>ข่าว</h2>
            <nav class="d-flex justify-content-center">
                <ol class="breadcrumb mt-3">
                    <li class="breadcrumb-item"><a href="index_admin.php">หน้าแรก</a></li>
                    <li class="breadcrumb-item"><a href="news.php">ข่าวประชาสัมพันธ์</a></li>
                    <li class="breadcrumb-item"><a href="news_act.php">ข่าวกิจกรรม</a></li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="col-12">
                <div class="card">
                    <div class="card-site">
                        <h5 class="card-title text-center">แก้ไขข้อมูลข่าว</h5>
                    </div>
                    <?php
                    // ดึงข้อมูลเอกสารที่ต้องการแก้ไข
                    if (isset($_GET['news_no'])) {
                        $news_no = intval($_GET['news_no']); // ทำความสะอาดข้อมูล
                        $sqlQuery = "SELECT * FROM news WHERE news_no = $news_no";
                        $query = mysqli_query($conn, $sqlQuery);

                        if ($query) {
                            $doc = mysqli_fetch_assoc($query);
                            if ($doc) {
                                // เก็บข้อมูลที่ใช้ในแบบฟอร์ม
                                $news_no = $doc['news_no'];
                                $news_date = $doc['news_date'];
                                $news_title = $doc['news_title'];
                                $news_type = $doc['news_type'];
                                $news_img = $doc['news_img'];
                                $news_details = $doc['news_details'];
                                $news_gallery = $doc['news_gallery'];
                            } else {
                                echo "ไม่พบข้อมูล.";
                                exit; // หยุดการทำงานถ้าไม่มีข้อมูล
                            }
                        } else {
                            echo "เกิดข้อผิดพลาดในการสอบถามข้อมูล: " . mysqli_error($conn);
                            exit; // หยุดการทำงานหากเกิดข้อผิดพลาด
                        }
                    } else {
                        echo "หมายเลขดาวน์โหลดไม่ได้ถูกกำหนด.";
                        exit; // หยุดการทำงานหากไม่มี news_no
                    }
                    ?>
                    <div class="card-body">
                        <div class="form">
                        <form action="newsUpdate.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="news_no" value="<?php echo $news_no; ?>">
                            <div class="form-group mb-2">
                                <label for="news_date" class="form-label">เดือน/วัน/ปี ที่ลงข่าว:</label>
                                <input type="date" name="news_date" class="form-control" value="<?php echo htmlspecialchars($news_date); ?>" required>
                            </div>

                            <div class="form-group mb-2">
                                <label for="news_title" class="form-label">หัวข้อข่าว:</label>
                                <input type="text" name="news_title" class="form-control" value="<?php echo htmlspecialchars($news_title); ?>" required>
                            </div>

                            <div class="form-group mb-2">
                                <label for="news_type" class="form-label">ประเภทข่าว:</label>
                                <select name="news_type" class="form-control" required>
                                    <option value="1" <?php echo ($news_type == "1") ? "selected" : ""; ?>>ข่าวประชาสัมพันธ์ทุน</option>
                                    <option value="2" <?php echo ($news_type == "2") ? "selected" : ""; ?>>ข่าวกิจกรรม</option>
                                </select>
                            </div>

                            <div class="form-group mb-2">
                                <label for="news_img" class="form-label">รูปภาพหลัก:</label>
                                <input type="file" name="news_img" class="form-control">
                                <!-- แสดงรูปภาพเก่า -->
                                <?php if (!empty($news_img) && file_exists('../pic/newspicture/' .$news_img)): ?>
                                    <div class="mt-3">
                                        <img src="../pic/newspicture/<?php echo $news_img; ?>" alt="รูปภาพปัจจุบัน" width="200" class="img-thumbnail">
                                    </div>
                                <?php else: ?>
                                    <p>ไม่มีรูปภาพที่จะแสดง</p>
                                <?php endif; ?>
                                <input type="hidden" name="old_news_img" value="<?php echo htmlspecialchars($news_img); ?>">
                            </div>


                            <div class="form-group mb-4">
                                <label for="news_details" class="form-label">รายละเอียดข่าว:</label>
                                <textarea id="summernote" name="news_details" rows="10" cols="40" class="form-control" style="height: 120px"><?php echo htmlspecialchars($news_details); ?></textarea>
                            </div>

                            <div class="form-group mb-2">
                                <label for="news_gallery" class="form-label">รูปภาพเพิ่มเติม:</label>
                                <input type="file" name="news_gallery[]" class="form-control mb-2" multiple>
                                <!-- แสดงรูปภาพเก่าในแกลเลอรี -->
                                <?php 
                                if ($news_gallery): 
                                    $gallery_images = explode(',', $news_gallery); // แยกรูปภาพจากฐานข้อมูล
                                    foreach ($gallery_images as $image): ?>
                                        <img src="../pic/newspicture/<?php echo $image; ?>" alt="Gallery Image" width="100">
                                    <?php endforeach; 
                                endif; ?>
                                <input type="hidden" name="old_news_gallery" value="<?php echo htmlspecialchars($news_gallery); ?>">
                            </div>
                            
                            <div class="text-center mt-2">
                                <button type="submit" class="btn btn-primary">บันทึกการแก้ไข</button>
                            </div>
                            
                        </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include("footer_admin.php") ?>

    <div id="summernote">
    <!-- Summernote -->
    <script>
        $('#summernote').summernote({
            placeholder: 'ใส่รายละเอียดข่าวที่นี่',
            tabsize: 2,
            height: 120,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            callbacks: {
                onInit: function() {
                    $(this).summernote('code', '');
                }
            }
        });
    </script>
</body>


