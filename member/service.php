<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>บริการ - งานวิเทศสัมพันธ์ | มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน</title>

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
    <section class="service-header text-center">
        <div class="container">
            <div class="col-lg-12 col-12">
                <h1>การบริการ</h1>
            </div>
        </div>
    </section>

    <section class="section-padding service">
        <div class="container">
            <div class="row g-4">
                <?php 
                    $sql = "SELECT * FROM service";
                    $result = mysqli_query($conn,$sql);
                    if ($result && mysqli_num_rows($result) > 0) {
                        $i=1;
                        while ($row=mysqli_fetch_assoc($result)) { 
                             echo 
                            '<div class="col-lg-6">
                                <div class="service-item">
                                    <a class="service-content" href="SVdetail.php?service_no='.$row['service_no'].'">
                                        <h3 hidden>'.$row['service_no'].'</h3>
                                        <h3>'.$row['service_title'].'</h3>
                                    </a>
                                </div>
                            </div>';
                       }
                    }
                
                ?>
                
            </div>
        </div>
    </section>



    <?php
        include("footer.php")
    ?>
</body>