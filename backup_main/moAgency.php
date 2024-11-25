<?php include("database/connect.php");
$sqlag = "SELECT * FROM agency_university WHERE ag_id='".$_GET['ag_id']."'";
$query = mysqli_query($conn,$sqlag);
$ag = mysqli_fetch_assoc($query);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $ag['agencyname_thai']; ?> - งานวิเทศสัมพันธ์ | มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน</title>

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
            <?php
                $sqlmou = "SELECT * FROM mou";
                $querymou = mysqli_query($conn,$sqlmou);
                $mou = mysqli_fetch_assoc($querymou); 
            ?>
            <div class="col-lg-12 col-12">
                <h5>ข้อมูลการทำความร่วมมือ</h5>
                <h1><?php echo $ag['agencyname_thai']; ?></h1>
            </div>
        </div>
    </section>

    <section class="mou-area">
        <div class="container">
            <div class="d-flex align-items-center justify-content-center">
                <form action="moAgency.php" class="custom-form search-form col-lg-8 col-12 me-3" method="get">
                    <input type="hidden" name="ag_id" value="<?php echo $_GET['ag_id'] ?>">
                    <input type="text" class="search-control" name="search_mou" placeholder="ค้นหาบันทึกความร่วมมือ">
                    <button type="submit" class="form-control">
                        <i class="bi-search"></i>
                    </button>
                </form>
                <div class="filters">
                    <button data-filter="*" class="moumore-btn me-2 active">ทั้งหมด</button>
                    <button data-filter=".1" class="moumore-btn me-2">MOI</button>
                    <button data-filter=".2" class="moumore-btn me-2">MOU</button>
                    <button data-filter=".3" class="moumore-btn">MOA</button>
                </div>
            </div>
            <div class="row g-4 mt-3" id="DBmou"> <!-- ไล่ลำดับจากวันที่ลงนามล่าสุด -->
                <?php function DateThai($strDate) {
                    $strYear = date("Y",strtotime($strDate))+543;
                    $strMonth= date("n",strtotime($strDate));
                    $strDay= date("j",strtotime($strDate));
                    $strMonthCut = Array("","มกราคม.","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
                    $strMonthThai=$strMonthCut[$strMonth];
                    return "$strDay $strMonthThai $strYear"; }
                ?>
                <?php
                $search_query = "";
                if (isset($_GET['search_mou']) && !empty($_GET['search_mou'])) {
                    $search_query = mysqli_real_escape_string($conn, $_GET['search_mou']);
                    $sql = "SELECT * FROM mou WHERE ag_id='".$_GET['ag_id']."' AND nameMou LIKE '%" . $search_query . "%' ORDER BY dateStart DESC";
                } else {
                    // หากไม่มีการค้นหา ให้แสดงข้อมูลทั้งหมด
                    $sql = "SELECT * FROM mou WHERE ag_id='".$_GET['ag_id']."' ORDER BY dateStart DESC";
                }
                $query = mysqli_query($conn, $sql);
                    while ($row=mysqli_fetch_assoc($query)) { ?>
                        <div class="col-lg-6 item <?php echo $row['Mo_type']; ?>">
                            <div class="mou-detail-item">
                                <div class="d-flex">
                                    <div class="mou-content col-lg-11">
                                        <h3><?php echo $row['nameMou']; ?></h3>
                                        <h5><?php echo DateThai($row['dateStart']) ." - ". DateThai($row['dateExpired']); ?></h5>
                                    </div>
                                    <?php
                                        if ($row['Mo_type']==1) {
                                            echo '<div class="col-lg-3"><span class="Mtype-MOI">MOI</span></div>';
                                        } elseif ($row['Mo_type']==2) {
                                            echo '<div class="col-lg-3"><span class="Mtype-MOU">MOU</span></div>';
                                        } elseif ($row['Mo_type']==3) {
                                            echo '<div class="col-lg-3"><span class="Mtype-MOA">MOA</span></div>';
                                        }
                                    ?>
                                </div>
                                <div class="d-flex justify-content-center mt-2">
                                    <a href="moDetails.php?mouid=<?php echo $row['mouid'] ?>" class="moudetail-btn me-2">ดูรายละเอียด</a>
                                </div>
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
            var $container = $('#DBmou').isotope({
                itemSelector: '.item',
                isFitWidth: false
            });

            $(window).resize(function() {
                $container.isotope({
                    columnWidth: '.col-lg-6'
                });
            });

            $container.isotope({ filter: '*'});

            $('.filters button').on('click', function() {
                var filterValue = $(this).attr('data-filter');
                $container.isotope({ filter: filterValue});
                $('.filters button').removeClass('active');
                $(this).addClass('active');
            });
        }
        siteIstotope();
    </script>
</body>