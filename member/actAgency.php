<?php include("../database/connect.php");
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

    <section class="mou-header section-bg text-center">
        <div class="container">
            <div class="col-lg-12 col-12">
                <h5>กิจกรรมการร่วมมือทางวิชาการ</h5>
                <h1><?php echo $ag['agencyname_thai']; ?></h1>
            </div>
        </div>
    </section>

    <section class="mou-area">
        <div class="container">
            <div class="d-flex align-items-center justify-content-center">
                <form action="actAgency.php" class="custom-form search-form col-lg-8 col-12 me-3" method="get">
                    <input type="hidden" name="ag_id" value="<?php echo $_GET['ag_id'] ?>">
                    <input type="text" class="search-control" placeholder="ค้นหาชื่อกิจกรรม" name="search_act">
                    <button type="submit" class="form-control">
                        <i class="bi-search"></i>
                    </button>
                </form>
            </div>
            <div class="row g-4 mt-3">
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
                if (isset($_GET['search_act']) && !empty($_GET['search_act'])) {
                    $search_query = mysqli_real_escape_string($conn, $_GET['search_act']);
                    $sql = "SELECT * FROM activity WHERE ag_id='".$_GET['ag_id']."' AND act_name LIKE '%" . $search_query . "%' ORDER BY act_id DESC";
                } else {
                    // หากไม่มีการค้นหา ให้แสดงข้อมูลทั้งหมด
                    $sql = "SELECT * FROM activity WHERE ag_id='".$_GET['ag_id']."' ORDER BY act_id DESC";
                }
                $result = mysqli_query($conn, $sql);
                while ($row=mysqli_fetch_assoc($result)) { ?> <!-- ไล่ลำดับจากวันที่ลงนามล่าสุด -->
                    <div class="col-lg-6">
                        <div class="mou-detail-item">
                            <div class="d-flex">
                                <div class="mou-content col-lg-11">
                                    <h3><?php echo $row['act_name']; ?></h3>
                                    <h5><?php echo DateThai($row['act_dateStart']) ." - ". DateThai($row['act_dateEnd']); ?></h5>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-2">
                                <a href="actDetails.php" class="moudetail-btn me-2">ดูรายละเอียด</a>
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
    
</body>