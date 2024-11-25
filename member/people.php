<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>โครงสร้างบุคลากร - งานวิเทศสัมพันธ์ | มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน</title>

    <!-- Favicons -->
    <link href="../assets/img/RMUTI.png" rel="icon">
    <link href="../assets/img/RMUTI2.png" rel="">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" crossorigin rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- CSS FILES -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../assets/css/main.css" rel="stylesheet">
    <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
</head>

<body>
    <?php include("menu.php") ?>
    <main>
        <section class="about-header section-bg text-center">
            <div class="container">
                <div class="col-lg-12 col-12">
                    <h1 class="text-white" style="font-weight: 400; font-size: 48px;">
                        โครงสร้างบุคลากร
                    </h1>
                </div>
            </div>

        </section>

        <section class="section-padding">
            <div class="container">
                <?php
                $sql = "SELECT * FROM about WHERE about_type='บุคลากร' AND about_no BETWEEN 6 AND 9";
                $query = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($query)) { ?>
                    <div class="member d-flex justify-content-center mb-5">
                        <div>
                            <div class="member-img">
                                <img src="../pic/people/<?php echo $row['about_img'] ?>" class="img-fluid">
                            </div>
                            <div class="member-info text-center">
                                <h4><?php echo $row['about_title'] ?></h4>
                                <span><?php echo $row['about_details'] ?></span>
                            </div>
                        </div>
                    </div>
                <div class="row mb-2">
                    <?php }
                    $sql2 = "SELECT * FROM about WHERE about_type='บุคลากร' AND about_no NOT IN (6,7,8,9)";
                    $result = mysqli_query($conn, $sql2);
                    while ($row2 = mysqli_fetch_assoc($result)) { ?>
                        <div class="col-lg-6 member">
                            <div class="member-img" style="margin: 0 110px !important;">
                                <img src="../pic/people/<?php echo $row2['about_img'] ?>" class="img-fluid" >
                            </div>
                            <div class="member-info text-center">
                                <h4><?php echo $row2['about_title'] ?></h4>
                                <span><?php echo $row2['about_details'] ?></span>
                            </div>
                        </div>
                    <?php } ?>
                </div>




            </div>
        </section>
    </main>

    <?php
    include("footer.php");
    ?>
</body>