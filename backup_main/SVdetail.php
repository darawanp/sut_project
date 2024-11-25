<?php include("database/connect.php");
$sql = "SELECT * FROM service WHERE service_no='".$_GET['service_no']."'";
$query = mysqli_query($conn,$sql);
$service = mysqli_fetch_assoc($query);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $service['service_title']; ?> - งานวิเทศสัมพันธ์ | มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน</title>

    <!-- Favicons -->
    <link href="assets/img/RMUTI.png" rel="icon">
    <link href="assets/img/RMUTI2.png" rel="">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" crossorigin rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS FILES -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
</head>

<body>
    <?php include("menu.php") ?>
    <section class="service-header text-center">
        <div class="container">
            <div class="col-lg-12 col-12">
                <h1>รายละเอียดการบริการ</h1>
            </div>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <div class="col-lg-10 col-12  mx-auto">
                <?php 
                    $sqlSelect = "SELECT * FROM service WHERE service_no='".$_GET['service_no']."'";
                    $result = mysqli_query($conn,$sqlSelect);
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row=mysqli_fetch_assoc($result)) { ?>
                            <div class="section-details mb-4 text-center">
                                <?php echo $row['service_title']; ?>
                                <hr>
                            </div>
                            <div class="service-detail">
                                <h4><?php echo $row['service_details']; ?></h4>
                            </div>
                        <?php }
                    } else {
                    echo '<tr><td colspan="6" align="center">ไม่พบข้อมูล</td></tr>';
                    }
                ?>
                
            </div>
        </div>
    </section>




    <?php
        include("footer.php")
    ?>
</body>