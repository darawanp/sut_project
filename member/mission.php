<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>พันธกิจ/ภารกิจหลัก - งานวิเทศสัมพันธ์ | มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน</title>

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
        <section class="about-header text-center">
            <div class="container">
                <div class="col-lg-12 col-12">
                    <h1>พันธกิจ - ภารกิจหลัก</h1>
                </div>
            </div>
            
        </section>

        <section class="section-padding mb-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <?php
                            $sqlSelect = "SELECT * FROM about WHERE about_no=2";
                            $query = mysqli_query($conn,$sqlSelect);
                            $row = mysqli_fetch_assoc($query);
                        ?>
                        <div class="custom-text-box h-100">
                            <h3 class="text-center mb-4"><span>พันธกิจ</span></h3>
               -             <p><?php echo $row['about_details']; ?></p>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <?php
                            $sqlSelect2 = "SELECT * FROM about WHERE about_no=3";
                            $query2 = mysqli_query($conn,$sqlSelect2);
                            $row2 = mysqli_fetch_assoc($query2);
                        ?>
                        <div class="custom-text-box h-100">
                            <h3 class="mb-4 text-center"><span>ภารกิจหลัก</span></h3>
                            <p><?php echo $row2['about_details']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php
        include("footer.php");
    ?>
</body>