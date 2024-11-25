<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>บุคลากร - Admin Management</title>
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
            <h2>บุคลากร</h2>
            <nav class="d-flex justify-content-center">
                <ol class="breadcrumb mt-3">
                    <li class="breadcrumb-item"><a href="index_admin.php">หน้าแรก</a></li>
                    <li class="breadcrumb-item"><a href="people.php">บุคลากร</a></li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-site d-flex align-items-center">
                    <h5 class="card-title">ข้อมูลบุคลากรทั้งหมด</h5>
                    <a href="peopleCreate.php" class="ms-auto">
                        <button class="btn btn-primary btn-round me-2">
                            <i class="card-icon bi bi-person-fill-up me-1"></i>
                            เพิ่มบุคลากร
                        </button>
                    </a>
                </div>

                <div class="card-body">
                    <div class="row">
                        <?php
                        $sql = "SELECT * FROM about WHERE about_type='บุคลากร'";
                        $query = mysqli_query($conn, $sql);
                        if ($result = mysqli_num_rows($query) > 0) {
                            while ($row = mysqli_fetch_assoc($query)) { ?>
                                <div class="col-lg-4 col-md-6 mt-4 member">
                                    <div class="member-img">
                                        <img src="../pic/people/<?php echo $row['about_img'] ?>" class="img-fluid">
                                        <div class="social">
                                            <a href="peopleEdit.php?about_no=<?php echo $row['about_no'] ?>"><i class="bi bi-pencil-square"></i></a>
                                        </div>
                                    </div>
                                    <div class="member-info text-center">
                                        <h4><?php echo $row['about_title'] ?></h4>
                                        <span><?php echo $row['about_details'] ?></span>
                                    </div>
                                </div>
                            <?php }
                        } else
                            echo '<table><tr><td colspan="6" align="center">ไม่พบข้อมูล</td></tr></table>';
                        ?>
                    </div>

                </div>
            </div>
        </section>


    </main>




    <?php
    include("footer_admin.php")
        ?>

</body>