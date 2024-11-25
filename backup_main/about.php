<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>ประวัติ - งานวิเทศสัมพันธ์ | มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน</title>

    <!-- Favicons -->
    <link href="assets/img/RMUTI.png" rel="icon">
    <link href="assets/img/RMUTI2.png" rel="">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" crossorigin rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- CSS FILES -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
</head>

<body>
    <?php include("menu.php") ?>
    <main>
        <section class="about-header text-center">
            <div class="container">
                <div class="col-lg-12 col-12">
                    <h1>ประวัติ</h1>
                </div>
            </div>

        </section>

        <section class="section-padding">
            <div class="container">
                <?php
                $sqlSelect = "SELECT * FROM about WHERE about_no=1";
                $result = mysqli_query($conn, $sqlSelect);
                $about = mysqli_fetch_assoc($result);
                ?>
                <div class="col-12">
                    <div class="custom-text-box">
                        <h3 class="text-center">ประวัติความเป็นมาของ<span>งานวิเทศสัมพันธ์</span></h3>
                        <h3 class="text-center mb-4">มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน</h3>
                        <p><?php echo $about['about_details']; ?></p>
                    </div>
                </div>
            </div>

        </section>
    </main>

    <?php
    include("footer.php");
    ?>
</body>