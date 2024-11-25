<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>เพิ่มบุคลากร - Admin Management</title>
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
            <h2>บุคลากร</h2>
            <nav class="d-flex justify-content-center">
                <ol class="breadcrumb mt-3">
                    <li class="breadcrumb-item"><a href="index_admin.php">หน้าแรก</a></li>
                    <li class="breadcrumb-item"><a href="people.php">บุคลากร</a></li>
                </ol>
            </nav>
        </div>

        <section class="section profile">
            <div class="card">
                <div class="card-site text-center">
                    <h5 class="card-title">เพิ่มข้อมูลบุคลากร</h5>
                </div>

                <div class="card-body">
                    <div class="detail">
                        <form action="peopleInsert.php" method="POST" enctype="multipart/form-data">
                            <?php
                                $about_title=null;
                                $about_details=null;
                                $about_img=null;
                                $about_type="บุคลากร";
                            ?>
                            <div class="row mb-2">
                                <input type="hidden" name="about_type" value="<?php echo $about_type; ?>">
                                <label class="col-md-4 col-lg-3 col-form-label">ชื่อ-สกุล</label>
                                <div class="col-md-8 col-lg-9 mb-2">
                                    <input name="about_title" type="text" class="form-control" value="<?php echo $about_title; ?>">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-4 col-lg-3 col-form-label">ตำแหน่ง</label>
                                <div class="col-md-8 col-lg-9 mb-2">
                                    <input name="about_details" type="text" class="form-control" value="<?php echo $about_details; ?>">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-4 col-lg-3 col-form-label">แนบรูปบุคลากร</label>
                                <div class="col-md-8 col-lg-9 mb-2">
                                    <input name="about_img" type="file" class="form-control" accept=".jpg,.jpeg,.png,.gif">
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

    <?php
        include("footer_admin.php");
    ?>
</body>