<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>เลือกวัน เวลาคุมสอบ</title>

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
    <?php include("menu.php"); ?>
    <main>
        <section class="hero-section hero-section-full-height">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-lg-12 col-12 p-0">
                        <div id="hero-slide" class="carousel carousel-fade slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php
                                $sql = "SELECT * FROM picture ORDER BY picture_no DESC";
                                $query = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_assoc($query)) { ?>
                                    <div class="carousel-item active">
                                        <img src="../pic/slide/<?php echo $row['picture_file']; ?>"
                                            class="carousel-image img-fluid" alt="...">
                                    </div>
                                <?php }
                                ?>
                            </div>

                            <button class="carousel-control-prev" type="button" data-bs-target="#hero-slide"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>

                            <button class="carousel-control-next" type="button" data-bs-target="#hero-slide"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="counts">
            <div class="container">
                <div class="row counters">
                    <div class="col-lg-3 col-6 text-center">
                        <div class="counter-thumb">
                            <?php
                            $sqlag_uni = "SELECT * FROM agency_university";
                            $queryag = mysqli_query($conn, $sqlag_uni);
                            $numrowag = mysqli_num_rows($queryag)
                                ?>
                            <span class="counter-number" data-from="0" data-to="<?php echo $numrowag ?>"
                                data-speed="1000"></s>
                                <span class="counter-number-text"></span>
                        </div>
                        <p>หน่วยงาน</p>
                    </div>

                    <div class="col-lg-3 col-6 text-center">
                        <div class="counter-thumb">
                            <span class="counter-number" data-from="0" data-to="150" data-speed="1000"></s>
                                <span class="counter-number-text"></span>
                        </div>
                        <p>หน่วยงานความร่วมมือ</p>
                    </div>

                    <div class="col-lg-3 col-6 text-center">
                        <div class="counter-thumb">
                            <span class="counter-number" data-from="0" data-to="1000" data-speed="1000"></s>
                                <span class="counter-number-text"></span>
                        </div>
                        <p>บันทึกความร่วมมือ</p>
                    </div>

                    <div class="col-lg-3 col-6 text-center">
                        <div class="counter-thumb">
                            <span class="counter-number" data-from="0" data-to="1500" data-speed="1000"></s>
                                <span class="counter-number-text"></span>
                        </div>
                        <p>กิจกรรม</p>
                    </div>

                </div>

            </div>

        </section>

        <section class="section-padding blog-posts">
            <div class="container">
            </div>
        </section>

        <section class="section-padding blog-posts" style="padding-top: 0 !important; padding-bottom: 70px !important;">
            <div class="container">

            </div>
        </section>
    </main>



    <?php
    include("footer.php");
    ?>
</body>

</html>