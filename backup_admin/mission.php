<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>พันธกิจ - Admin Management</title>
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
            <h2>พันธกิจ</h2>
            <nav class="d-flex justify-content-center mt-3">
                <a class="btn btn-warning me-2" href="mission.php">พันธกิจ</a>
                <a class="btn btn-light" href="M_mission.php">ภารกิจหลัก</a>
            </nav>
        </div>

        <section class="section">
            <div class="col-12">
                <div class="card">
                    <div class="card-site mb-4">
                        <h5 class="card-title text-center">พันธกิจ</h5>
                    </div>
                    <div class="card-body">
                        <form action="aboutUpdate.php" method="POST">
                            <?php
                            $sqlSelect = "SELECT * FROM about WHERE about_no=2";
                            $query = mysqli_query($conn, $sqlSelect);
                            $about = mysqli_fetch_assoc($query);

                            $about_no = $about['about_no'];
                            $about_title = $about['about_title'];
                            $about_details = $about['about_details'];
                            $about_img = $about['about_img'];
                            $about_type = $about['about_type'];
                            ?>
                            <input type="hidden" name="about_no" value="<?php echo $about_no; ?>">
                            <input type="hidden" name="about_title" value="<?php echo $about_title; ?>">
                            <input type="hidden" name="about_type" value="<?php echo $about_type; ?>">
                            <input type="hidden" name="about_img" value="<?php echo $about_img; ?>">
                            <textarea id="summernote" name="about_details"><?php echo $about_details; ?></textarea>

                            <div class="text-center mt-2">
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