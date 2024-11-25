<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>ระบบบันทึกข้อมูลการลงนาม - งานวิเทศสัมพันธ์ | มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน</title>

    <!-- Favicons -->
    <link href="../assets/img/RMUTI.png" rel="icon">
    <link href="../assets/img/RMUTI2.png" rel="">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" crossorigin rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">

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
                <h5>ข้อมูลการทำความร่วมมือทั้งหมด</h5>
                <h1><?php echo $_SESSION['campus']; ?></h1>
            </div>
        </div>
    </section>

    <section class="mou-area">
        <div class="container">
            <?php 
                $sql = "SELECT * FROM mou1 ORDER BY dateStart DESC";
                $query = mysqli_query($conn,$sql);
            ?>
            <div class="d-flex align-items-center justify-content-center">
                <form action="#" class="custom-form search-form col-lg-7 col-12 me-3" method="post" role="form">
                    <input type="search" class="search-control" placeholder="Search" aria-label="Search">
                    <button type="submit" class="form-control">
                        <i class="bi-search"></i>
                    </button>
                </form>
                <a href="mouSystem.php" class="moudetail-btn me-2"><i class="bi bi-clipboard2-plus-fill me-2"></i>เพิ่มบันทึกใหม่</a>
                <a href="" class="mouinsert-btn"><i class="bx bxs-report me-2" style="font-size:24px;"></i>ดูรายงาน</a>
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
                    while ($row=mysqli_fetch_assoc($query)) { ?>
                        <div class="col-lg-6">
                            <div class="mou-detail-item">
                                <div class="d-flex">
                                    <div class="mou-content col-lg-11">
                                        <h3><?php echo $row['nameMou'] ?></h3>
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
                                    <a href="<?php echo 'moDetailsN.php?mouid='.$row['mouid']; ?>" class="moudetail-btn me-2">ดูรายละเอียด</a>
                                    <a href="<?php echo 'mouallEdit.php?mouid='.$row['mouid']; ?>" class="mouedit-btn setting me-2">แก้ไข</a>
                                    <a href="<?php echo 'mouDelect.php?mouid='.$row['mouid']; ?>" class="moudelect-btn me-2">ลบ</a>
                                </div>
                            </div>
                        </div>        
                    <?php }
                ?>
                
            </div>
        </div>
    </section>

    <?php
        include("footer.php")
    ?>
</body>