<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>เพิ่มข่าวใหม่ - Admin Management</title>
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
            <div class="card">
                <div class="card-site">
                    <h5 class="card-title text-center">รายละเอียดของข่าว</h5>
                </div>

                <div class="card-body">
                    <div class="form">
                        <form name="AddNews" action="newsInsert.php" method="POST" enctype="multipart/form-data">
                            <div class="row mb-2">
                                <input type="hidden" name="news_no">
                                <label class="col-md-4 col-lg-3 col-form-label">เดือน/วัน/ปี ที่ลงข่าว</label>
                                <div class="input-group mb-2">
                                    <input type="date" name="news_date" class="form-control" required>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <label class="col-md-4 col-lg-3 col-form-label">หัวข้อข่าว</label>
                                <div class="col-md-8 col-lg-9 mb-2">
                                    
                                    <input name="news_title" type="text" class="form-control" required><br>
                                    <select class="form-select" name="news_type" id="news_type">
                                        <?php  
                                            $news_types = array('0' => "เลือกประเภทข่าว", '1' => "ข่าวประชาสัมพันธ์ทุน", '2' => "ข่าวกิจกรรม");
                                            foreach($news_types as $key => $value){
                                                echo '<option value="'.$key.'">'.$value.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div> 
                            </div>

                            <div class="row mb-2">
                                <label class="col-md-4 col-lg-3 col-form-label">รูปภาพหลัก</label>
                                <div class="col-md-8 col-lg-9 mb-2">
                                    <input type="file" name="news_img" accept=".jpg,.jpeg,.png,.gif">
                                </div>
                            </div>

                            <div class="row mb-2">
                                <label class="col-md-4 col-lg-3 col-form-label">รายละเอียดข่าว</label>
                                <div class="col-md-8 col-lg-9 mb-2">
                                    <textarea id="summernote" name="news_details"></textarea>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <label class="col-md-4 col-lg-3 col-form-label">รูปภาพเพิ่มเติม</label>
                                <div class="col-md-8 col-lg-9 mb-2">
                                    <input type="file" name="news_gallery[]" accept=".jpg,.jpeg,.png,.gif" multiple>
                                </div>
                                <div class="d-flex">
                                    <h6 style="font-size:18px; font-weight:500; color:red;" class="me-2">รูปภาพเพิ่มเติม</h6>
                                    <span style="color:red;">*ถ้าต้องการเลือกหลายรูป ให้ลากเมาส์ครอบทุกรูปที่ต้องการ</span>
                                </div>
                                
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success">บันทึก</button>
                                <button type="reset" class="btn btn-warning">ล้างข้อมูล</button>
                            </div>
                        </form>
                    </div>
                </div> 
            </div>
        </section>
    </main>

    <?php include("footer_admin.php") ?>

    
    </div>
</body>
