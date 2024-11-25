<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>แก้ไขรูปภาพ - Admin Management</title>
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
            <h2>จัดการรูปภาพ</h2>
            <nav class="d-flex justify-content-center">
                <ol class="breadcrumb mt-3">
                    <li class="breadcrumb-item"><a href="index_admin.php">หน้าแรก</a></li>
                    <li class="breadcrumb-item"><a href="manage_picture.php">รวมรูปภาพ Banner</a></li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="col-12">
                <div class="card">
                    <div class="card-site">
                        <h5 class="card-title text-center">แก้ไขรูปภาพ</h5>
                    </div>
                    <?php
                        if (isset($_GET['picture_no'])) {
                            $picture_no = intval($_GET['picture_no']);
                            $sqlQuery = "SELECT * FROM picture WHERE picture_no = $picture_no";
                            $query = mysqli_query($conn, $sqlQuery);

                            if ($query) {
                                $doc = mysqli_fetch_assoc($query);
                                if ($doc) {
                                    $picture_no = $doc['picture_no'];
                                    $picture_file = $doc['picture_file'];
                                    $imagePath = "images/slide/" . $picture_file; // พาธของรูปภาพในโฟลเดอร์
                                } else {
                                    echo "ไม่พบข้อมูล.";
                                    exit;
                                }
                            } else {
                                echo "เกิดข้อผิดพลาดในการสอบถามข้อมูล: " . mysqli_error($conn);
                                exit;
                            }
                        } else {
                            echo "ไม่พบเลขที่รูปภาพ";
                            exit;
                        }
                    ?>

                    <div class="card-body">
                        <div class="form">
                            <form action="manage_pictureUpdate.php" method="post" id="f1" enctype="multipart/form-data">
                                <input type="hidden" name="picture_no" value="<?php echo isset($picture_no) ? $picture_no : ''; ?>">
                                
                                <div class="row-mb2">
                                    <label for="picture_file">รูปภาพหลัก:</label>
                                    
                                    <?php if (!empty($picture_file) && file_exists('../pic/slide/' . $picture_file)): ?>
                                        <div class="mt-3">
                                            <!-- แสดงรูปภาพปัจจุบัน -->
                                            <img src="../pic/slide/<?php echo $picture_file; ?>" alt="รูปภาพปัจจุบัน" width="200" class="img-thumbnail">
                                        </div>
                                    <?php else: ?>
                                        <p>ไม่พบรูปภาพ</p>
                                    <?php endif; ?>
                                    
                                    <!-- ส่วนสำหรับอัปโหลดรูปภาพใหม่ -->
                                    <input type="file" name="picture_file" id="picture_file" class="form-control mt-3">
                                    <div class="mt-3">
                                        <img id="preview" src="#" alt="รูปที่เลือก" width="200" class="img-thumbnail" style="display: none;">
                                    </div>
                                    <!-- ส่งค่าไฟล์เก่าไปด้วยหากไม่มีการอัปโหลดใหม่ -->
                                    <input type="hidden" name="old_picture_file" value="<?php echo $picture_file; ?>">
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success">บันทึก</button>
                            </form>       
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php
        include("footer_admin.php")
    ?>

    <script>
        document.getElementById('picture_file').addEventListener('change', function(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('preview');
                output.src = reader.result;
                output.style.display = 'block'; // แสดงรูปภาพที่เลือกใหม่
            };
            reader.readAsDataURL(event.target.files[0]);
        });
    </script>

</body>
