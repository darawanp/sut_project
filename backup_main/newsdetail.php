<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>รายละเอียดข่าว - งานวิเทศสัมพันธ์ | มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน</title>

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
    <section class="news-header text-center">
        <div class="container">
            <div class="col-lg-12 col-12">
                <h1>รายละเอียดข่าว</h1>
            </div>
        </div>
    </section>

    <section class="section-padding blog-details">
        <div class="container">
            <div class="row">
                <?php function DateThai($strDate)
                {
                    $strYear = date("Y", strtotime($strDate)) + 543;
                    $strMonth = date("n", strtotime($strDate));
                    $strDay = date("j", strtotime($strDate));
                    $strMonthCut = array("", "มกราคม.", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
                    $strMonthThai = $strMonthCut[$strMonth];
                    return "$strDay $strMonthThai $strYear";
                }
                ?>
                <?php
                $sql = "SELECT * FROM news WHERE news_no='" . $_GET['news_no'] . "'";
                $query = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($query)) { ?>
                    <div class="col-lg-8 col-12">
                        <article>
                            <div class="post-img">
                                <img src="pic/newspicture/<?php echo $row['news_img'] ?>" class="img-fluid">
                            </div>

                            <h2 class="title"><?php echo $row['news_title'] ?></h2>

                            <div class="meta-top">
                                <ul>
                                    <li class="d-flex align-items-center active"><i class="bi bi-bookmark-fill active"></i>
                                        <?php
                                        if ($row['news_type'] == 1) {
                                            echo 'ประชาสัมพันธ์';
                                        } elseif ($row['news_type'] == 2) {
                                            echo 'กิจกรรม';
                                        }
                                        ?>
                                    </li>
                                    <li class="d-flex align-items-center"><i
                                            class="bi-calendar4"></i><?php echo DateThai($row['news_date']) ?></li>
                                </ul>
                            </div>

                            <div class="content">
                                <p><?php echo $row['news_details'] ?></p>
                            </div>

                            <div class="row">
                                <?php
                                if ($row['news_gallery']):
                                    $gallery_images = explode(',', $row['news_gallery']); // แยกรูปภาพจากฐานข้อมูล
                                    foreach ($gallery_images as $image): ?>
                                        <div class="col-lg-4 col-md-6 mb-2">
                                            <img src="pic/newspicture/<?php echo $image; ?>" alt="Gallery Image" class="img-fluid">
                                        </div>
                                    <?php endforeach;
                                endif; ?>
                            </div>


                        </article>
                    </div>
                <?php }
                ?>

                <div class="col-lg-4 col-12 mx-auto mt-4 mt-lg-0">
                    <form action="newsall.php" class="custom-form search-form" method="get">
                        <input type="hidden" name="page" value="1">
                        <input type="text" class="form-control" placeholder="ค้นหาข่าว" name="search_newsall">
                        <button type="submit" class="form-control">
                            <i class="bi-search"></i>
                        </button>
                    </form>
                    <div class="category-block d-flex flex-column">
                        <h5 class="mb-3">หมวดหมู่ข่าว</h5>
                        <?php
                        $numrow = mysqli_num_rows($query);
                        $sql2 = "SELECT * FROM news WHERE news_type=2";
                        $result = mysqli_query($conn, $sql2);
                        $numrow2 = mysqli_num_rows($result)
                            ?>
                        <a href="news.php?page=1" class="category-block-link">
                            ข่าวประชาสัมพันธ์
                            <span class="badge"><?php echo $numrow ?></span>
                        </a>
                        <a href="newsactivity.php?page=1" class="category-block-link">
                            ข่าวกิจกรรม
                            <span class="badge"><?php echo $numrow2 ?></span>
                        </a>
                    </div>
                    <h5 class="mt-5 mb-3">Recent news</h5>

                    <?php
                    $sqlSelect = "SELECT * FROM news ORDER BY news_date DESC LIMIT 5";
                    $query2 = mysqli_query($conn, $sqlSelect);
                    while ($row2 = mysqli_fetch_assoc($query2)) { ?>
                        <div class="news-block news-block-two-col mt-4 mb-2">
                            <div class="news-block-date">
                                <p>
                                    <i class="bi-calendar4 custom-icon me-1"></i>
                                    <?php echo DateThai($row2['news_date']) ?>
                                </p>
                            </div>
                            <div class="news-block-title ">
                                <h6>
                                    <a href="newsdetail.php?news_no=<?php echo $row2['news_no'] ?>"
                                        class="news-block-title-link">
                                        <?php echo $row2['news_title'] ?>
                                    </a>
                                </h6>
                            </div>
                        </div>
                    <?php }
                    ?>

                </div>
            </div>

        </div>
    </section>



    <?php
    include("footer.php")
        ?>
</body>