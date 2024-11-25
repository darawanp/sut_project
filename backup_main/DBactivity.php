<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>กิจกรรมการร่วมมือทางวิชาการ - งานวิเทศสัมพันธ์ | มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน</title>

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
    <section class="mou-header section-bg text-center">
        <div class="container">
            <div class="col-lg-12 col-12">
                <h1>
                    กิจกรรมการร่วมมือทางวิชาการ
                </h1>
            </div>
        </div>
    </section>

    <section class="mou-area">
    <div class="container"> 
            <?php 
                $sql = "SELECT * FROM agency_university";
                $result = mysqli_query($conn,$sql);
            ?>
            <ul class="mou-filters">
                <li class="active" data-filter="*">ทั้งหมด</li>
                <li data-filter=".1">ศูนย์กลางนครราชสีมา</li>
                <li data-filter=".2">วิทยาเขตขอนแก่น</li>
                <li data-filter=".3">วิทยาเขตสกลนคร</li>
                <li data-filter=".4">วิทยาเขตสุรินทร์</li>
            </ul>          
            
            <div class="row gy-4" id="mou">
                <?php
                    while ($row=mysqli_fetch_assoc($result)) { ?>
                        <div class="col-lg-3 col-md-6 item <?php echo $row['campus']; ?>">
                            <div class="mou-item">
                                <div class="mou-img">
                                    <img src="pic/logo/<?php echo $row['agency_img']; ?>" class="img-fluid" alt="">
                                </div>
                                <h3><?php echo $row['agencyname_thai']; ?></h3>
                                <a href="<?php echo 'actAgency.php?ag_id='.$row['ag_id']; ?>" class="mou-btn">ดูเพิ่มเติม</a>
                            </div>
                        </div>     
                <?php }
            ?>
            </div>
            
        </div>
    </section>


    <?php
        include("footer.php");
    ?>
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