<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>บันทึกการลงนามทั้งหมด - Admin Management</title>
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
            <h2>บันทึกการลงนาม</h2>
            <nav class="d-flex justify-content-center">
                <ol class="breadcrumb mt-3">
                    <li class="breadcrumb-item"><a href="index_admin.php">หน้าแรก</a></li>
                    <li class="breadcrumb-item"><a href="mouList.php">หน่วยงานในมหาวิทยาลัยทั้งหมด</a></li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <ul class="mou-filters">
                <li class="active" data-filter="*">ทั้งหมด</li>
                <li data-filter=".1">ศูนย์กลางนครราชสีมา</li>
                <li data-filter=".2">วิทยาเขตขอนแก่น</li>
                <li data-filter=".3">วิทยาเขตสกลนคร</li>
                <li data-filter=".4">วิทยาเขตสุรินทร์</li>
            </ul>

            <div class="row" id="mou">
                <?php
                $sql = "SELECT * FROM agency_university";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="col-lg-3 col-md-6 item <?php echo $row['campus'] ?>">
                        <div class="mou-item">
                            <div class="mou-img">
                                <img src="../pic/logo/<?php echo $row['agency_img'] ?>" class="img-fluid">
                            </div>
                            <h3><?php echo $row['agencyname_thai'] ?></h3>
                            <a href="<?php echo 'moAgencyList.php?ag_id=' . $row['ag_id']; ?>" class="mou-btn">ดูเพิ่มเติม</a>
                        </div>
                    </div>
                <?php }
                ?>

            </div>

        </section>
    </main>


    <?php include("footer_admin.php") ?>
    <script type="text/JAVASCRIPT">
        var siteIstotope = function() {
            var $container = $('#mou').isotope({
                itemSelector: '.item',
                isFitWidth: true
            });

            $(window).resize(function() {
                $container.isotope({
                    columnWidth: '.col-lg-3 .col-md-6'
                });
            });

            $container.isotope({ filter: '*'});

            $('.mou-filters li').on('click', function() {
                var filterValue = $(this).attr('data-filter');
                $container.isotope({ filter: filterValue});
                $('.mou-filters li').removeClass('active');
                $(this).addClass('active');
            });
        }
        siteIstotope();
    </script>
</body>