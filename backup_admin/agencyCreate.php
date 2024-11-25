<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>เพิ่มข้อมูลหน่วยงานใน มทร.อีสาน - Admin Management</title>
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
            <h2>หน่วยงาน</h2>
            <nav class="d-flex justify-content-center">
                <ol class="breadcrumb mt-3">
                    <li class="breadcrumb-item"><a href="index_admin.php">หน้าแรก</a></li>
                    <li class="breadcrumb-item"><a href="agency.php">หน่วยงาน</a></li>
                </ol>
            </nav>
        </div>
        <section>
            <div class="col-12">
            <div class="card">
                        <div class="card-site">
                            <h5 class="card-title text-center">เพิ่มหน่วยงาน</h5>
                        </div>
                        <div class="card-body">
                            <?php
                                $ag_id=null;
                                $agencyname_thai=null;
                                $agencyname_eng=null;
                                $abbreviation_thai=null;
                                $abbreviation_eng=null;
                                $campus=null;
                            ?>
                            <div class="form">
                            <form name="agencyAdd" action="agencyInsert.php" method="POST" enctype="multipart/form-data">
                                <div class="row mb-1 ">
                                    <input type="hidden" name="ag_id" value="<?php echo $ag_id; ?>">
                                    <label class="col-md-4 col-lg-6 col-form-label">ชื่อหน่วยงาน(ไทย)</label>
                                    <div class="col-md-8 col-lg-12 mb-2">
                                        <input name="agencyname_thai" type="text" class="form-control" value="<?php echo $agencyname_thai; ?>">
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label class="col-md-4 col-lg-6 col-form-label">ชื่อหน่วยงาน(อังกฤษ)</label>
                                    <div class="col-md-8 col-lg-12 mb-2">
                                        <input name="agencyname_eng" type="text" class="form-control" value="<?php echo $agencyname_eng; ?>">
                                    </div>
                                </div>
                                <div class="d-flex g-3 mb-1">
                                    <div class="row mb-1">
                                        <label class="col-md-4 col-lg-8 col-form-label">อักษรย่อ(ไทย)</label>
                                        <div class="col-md-6 col-lg-11 mb-2 ">
                                            <input name="abbreviation_thai" type="text" class="form-control" value="<?php echo $abbreviation_thai; ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-md-4 col-lg-8 col-form-label">อักษรย่อ(อังกฤษ)</label>
                                        <div class="col-md-8 col-lg-11 mb-2">
                                            <input name="abbreviation_eng" type="text" class="form-control" value="<?php echo $abbreviation_eng; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label class="col-md-4 col-lg-3 col-form-label">วิทยาเขต</label>
                                    <div class="col-md-8 col-lg-9 mb-2">
                                        <select class="form-select" name="campus">
                                            <option selected>เลือกวิทยาเขต</option>
                                            <option value="1" <?php echo ($campus=="1" ? 'selected' : ''); ?>>ศูนย์กลางนครราชสีมา</option>
                                            <option value="2" <?php echo ($campus=="2" ? 'selected' : ''); ?>>วิทยาเขตขอนแก่น</option>
                                            <option value="3" <?php echo ($campus=="3" ? 'selected' : ''); ?>>วิทยาเขตสกลนคร</option>
                                            <option value="4" <?php echo ($campus=="4" ? 'selected' : ''); ?>>วิทยาเขตสุรินทร์</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-4 col-lg-3 col-form-label">Logo</label>
                                    <div class="col-md-8 col-lg-9 mb-2">
                                        <input type="file" name="agency_img" class="form-control" accept=".jpg,.jpeg,.png,.gif">
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
            </div>
        </section>
    </main>

    <?php
        include("footer_admin.php");
    ?>
</body>