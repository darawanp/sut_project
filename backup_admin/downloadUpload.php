<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>เพิ่มเอกสาร - Admin Management</title>
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
            <h2>เอกสาร</h2>
            <nav class="d-flex justify-content-center">
                <ol class="breadcrumb mt-3">
                    <li class="breadcrumb-item"><a href="index_admin.php">หน้าแรก</a></li>
                    <li class="breadcrumb-item"><a href="download.php">เอกสาร</a></li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="col-12">
                <div class="card">
                    <div class="card-site">
                        <h5 class="card-title text-center">เพิ่มข้อมูลเอกสารดาวน์โหลดใหม่</h5>
                    </div>

                    <div class="card-body">
                        <div class="form">
                            <form name="upfile" action="downloadInsert.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="download_no">

                                <div class="row mb-2">
                                    <label class="col-md-4 col-lg-3 col-form-label">ชื่อไฟล์เอกสาร</label>
                                    <div class="input-group mb-2">
                                        <input name="file_name" type="text" style="flex: 3 2 auto;" class="form-control"
                                            required>
                                        <select name="file_type" class="form-select" required>
                                            <option value="" selected disabled>เลือกประเภทไฟล์</option>
                                            <option value="PDF">PDF</option>
                                            <option value="Word">Word</option>
                                            <option value="Excel">Excel</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <label class="col-md-4 col-lg-3 col-form-label">หมวดหมู่เอกสาร</label>
                                    <div class="col-md-8 col-lg-9 mb-2">
                                        <select name="doc_cate_no" class="form-select" required>
                                            <option selected disabled>เลือกหมวดหมู่เอกสาร</option>
                                            <?php
                                            // Query เพื่อดึงข้อมูลหมวดหมู่จากตาราง doc_category
                                            $sql = "SELECT doc_cate_no, doc_cate_name FROM doc_category";
                                            $result = mysqli_query($conn, $sql);

                                            // Loop ผ่านแต่ละแถวในผลลัพธ์เพื่อสร้างตัวเลือกใน select
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<option value="' . $row['doc_cate_no'] . '">' . $row['doc_cate_name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <label class="col-md-4 col-lg-3 col-form-label">แนบไฟล์</label>
                                    <div class="col-md-8 col-lg-9 mb-2">
                                        <input name="file_path" type="file" class="form-control" required>
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
        include("footer_admin.php")
    ?>
</body>