<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>แก้ไขถาม&ตอบ - Admin Management</title>
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
            <h2>ถาม & ตอบ</h2>
            <nav class="d-flex justify-content-center">
                <ol class="breadcrumb mt-3">
                    <li class="breadcrumb-item"><a href="index_admin.php">หน้าแรก</a></li>
                    <li class="breadcrumb-item"><a href="qa.php">ถาม-ตอบ</a></li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-site">
                    <h5 class="card-title text-center">แก้ข้อมูล ถาม-ตอบ</h5>
                </div>

                <div class="card-body">
                    <div class="form">
                        <form action="qaUpdate.php" method="POST">
                            <?php
                                $sqlQuery = "SELECT * FROM qa WHERE QA_no='".$_GET['QA_no']."'";
                                $query = mysqli_query($conn, $sqlQuery);
                                $qa = mysqli_fetch_assoc($query);

                                $QA_no = $qa['QA_no'];
                                $question = $qa['question'];
                                $answer = $qa['answer'];
                            ?>
                            <div class="row mb-4">
                                <input type="hidden" name="QA_no" value="<?php echo $QA_no; ?>">
                                <label class="form-label">เรื่อง</label>
                                <div class="col-12">
                                    <input name="question" type="text" class="form-control" value="<?php echo $question; ?>" >
                                </div>
                            </div>

                            <div class="row mb-2">
                                <label class="form-label">คำตอบ</label>
                                <div class="col-12">
                                    <textarea id="summernote" class="form-control" style="height: 100px;" name="answer"><?php echo $answer; ?></textarea>
                                </div>
                            </div>
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-success">บันทึก</button>
                            </div>
                        </form>
                    </div>
                    
                </div>
            </div>
        </section>
    </main>

    <?php
        include("footer_admin.php")
    ?>
</body>