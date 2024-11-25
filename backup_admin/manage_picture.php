<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>จัดการรูปภาพ Banner - Admin Management</title>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#but1").click(function (e) {
                $("#f1").toggle(1000);
            });

            $("#picture_file").change(function () {
                const file = this.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function (e) {
                        $("#preview").attr("src", e.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
</head>

<body>
    <?php include("menu_admin.php") ?>
    <main id="main" class="main">
        
        <div class="pagetitle text-center">
            <h2>จัดการสไลด์รูปภาพ</h2>
            <nav class="d-flex justify-content-center">
                <ol class="breadcrumb mt-3">
                    <li class="breadcrumb-item"><a href="index_admin.php">หน้าแรก</a></li>
                    <li class="breadcrumb-item"><a href="manage_picture.php">รวมรูปภาพ Banner</a></li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="container">
                <div class="center col-12">
                    <div class="card">
                        <div class="card-site text-center">
                            <h5 class="card-title">เพิ่มรูปภาพใหม่</h5>
                        </div>
                        <div class="card-body">
                            <div class="form">
                                <form action="manage_pictureInsert.php" method="post" id="f1"
                                    enctype="multipart/form-data">
                                    <input type="hidden" name="picture_no"
                                        value="<?php echo isset($picture_no) ? $picture_no : ''; ?>">
                                    <div class="row-mb2">
                                        <label for="picture_file">รูปภาพหลัก:</label>
                                        <input type="file" name="picture_file" id="picture_file" class="form-control"
                                            required>
                                        <div class="mt-3">
                                            <img id="preview" src="" alt="ตัวอย่างรูปที่เลือก" width="200"
                                                class="img-thumbnail">
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success">บันทึก</button>
                                        <button type="reset" class="btn btn-warning">ล้างข้อมูล</button>
                                    </div>
                                </form>
                            </div>
                            <button id="but1">ซ่อน/แสดง</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-site">
                            <h5 class="card-title">รูปภาพทั้งหมด</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">เลขที่รูปภาพ</th>
                                            <th>ไฟล์รูปภาพ</th>
                                            <th>รูปภาพ</th>
                                            <th class="text-center">การจัดการ</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $sql = "SELECT * FROM picture";
                                    $result = mysqli_query($conn, $sql);

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $imagePath = "../pic/slide/" . $row['picture_file'];
                                        echo '<tr>
                                        <td class="text-center">' . $row['picture_no'] . '</td>
                                        <td>' . htmlspecialchars($row['picture_file']) . '</td>
                                        <td>';
                                        if (file_exists($imagePath)) {
                                            echo '<a href="' . $imagePath . '" target="_blank">
                                            <img src="' . $imagePath . '" alt="' . htmlspecialchars($row['picture_file']) . '" width="200" class="img-thumbnail">
                                        </a>';
                                        } else {
                                            echo 'ไฟล์ไม่พบ';
                                        }
                                        echo '</td>
                                        <td class="text-center">
                                            <a href="manage_pictureEdit.php?picture_no=' . $row['picture_no'] . '&picture_file=' . urlencode($row['picture_file']) . '" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a><br>
                                            <a href="manage_pictureDelete.php?picture_no=' . $row['picture_no'] . '" class="btn btn-danger"><i class="bi bi-trash3-fill"></i></a>
                                        </td>
                                    </tr>';
                                    }
                                    ?>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- ปิด แท็ก row ข้างล่าง-->
            </div>
        </section>
    </main>

    <?php
    include("footer_admin.php");
    ?>
</body>

</html>