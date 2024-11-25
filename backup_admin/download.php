<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>เอกสารดาวน์โหลด - Admin Management</title>
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
                    <div class="card-site d-flex align-items-center">
                        <h5 class="card-title me-3">เอกสารทั้งหมด  |</h5>
                        <form name="form1" action="download.php" method="get" class="form-inline">
                        <div class="d-flex mt-3 mb-3">
                            <input type="text" class="form-control col-lg-7" name="search_doc" placeholder="ค้นหาชื่อเอกสาร">
                            <!-- ส่งค่า news_type ผ่านฟอร์ม -->
                            <div class="col-lg-1 col-xs-4 offset-md-1">    
                                <input type="submit" class="btn btn-success" value="ค้นหา">
                            </div>
                        </div>
                    </form>
                        <a href="downloadUpload.php" class="ms-auto">
                            <button class="btn btn-primary btn-round me-2">
                                <i class="card-icon bi bi-file-earmark-plus-fill me-1"></i>
                                เพิ่มเอกสาร
                            </button>
                        </a>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">เลขที่เอกสาร</th>
                                        <th>ชื่อไฟล์เอกสาร</th>
                                        <th>หมวดหมู่เอกสาร</th>
                                        <th>ไฟล์แนบ</th>
                                        <th class="text-center"><i class="bi bi-gear-fill"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // ตรวจสอบว่ามีการค้นหาหรือไม่
                                    $search_query = isset($_GET['search_doc']) ? mysqli_real_escape_string($conn, $_GET['search_doc']) : '';

                                    // สร้าง SQL query
                                    $sql = "SELECT download.*, doc_category.doc_cate_no, doc_cate_name 
                                            FROM download 
                                            LEFT JOIN doc_category ON download.doc_cate_no = doc_category.doc_cate_no 
                                            WHERE (download.file_name LIKE '%" . $search_query . "%' 
                                            OR doc_category.doc_cate_name LIKE '%" . $search_query . "%');";
                                    $result = mysqli_query($conn, $sql);

                                    if ($result && mysqli_num_rows($result) > 0) {
                                        $i = 1;
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<tr>
                                                <td class="text-center" hidden>' . $row['download_no'] . '</td>
                                                <td class="text-center">' . $i++ . '</td>
                                                <td>' . $row['file_name'] . '</td>
                                                <td>' . $row['doc_cate_name'] . '</td>
                                                <td>
                                                    <a href="../document/' . $row['file_path'] . '" target="_blank" class="btn btn-link">' . basename($row['file_path']) . '</a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="downloadEdit.php?download_no=' . $row['download_no'] . '" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
                                                    <a href="downloadDelete.php?download_no=' . $row['download_no'] . '" class="btn btn-danger" onclick="return confirm(\'คุณแน่ใจหรือว่าต้องการลบไฟล์นี้?\')"><i class="bi bi-trash3-fill"></i></a>
                                                </td>  
                                            </tr>';
                                        }
                                    } else {
                                        echo '<tr><td colspan="6" align="center">ไม่มีข้อมูล</td></tr>';
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

    <?php include("footer_admin.php"); ?>
</body>