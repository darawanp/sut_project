<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>ผลการค้นหาข่าว - งานวิเทศสัมพันธ์ | มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน</title>

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
    <section class="news-header text-center">
        <div class="container">
            <div class="col-lg-12 col-12">
                <h1>ผลการค้นหาข่าว</h1>
            </div>
        </div>
    </section>

    <section class="section-padding blog-posts">
        <div class="container">
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
            <div class="row gy-4">
                <?php
                $e_page = 9;
                $step_num = 0;
                $s_page=0;
                if (isset($_GET['page']) || (isset($_GET['page'])) && $_GET['page'] == 1) {
                    $_GET['page'] = 1;
                    $step_num = 0;
                    $s_page = 0;
                } else {
                    $s_page = $_GET['page'] - 1;
                    $step_num = $_GET['page'] - 1;
                    $s_page = $s_page * $e_page;
                }

                // ตรวจสอบว่ามีการค้นหาหรือไม่
                if (isset($_GET['search_newsall']) && !empty($_GET['search_newsall'])) {
                    $search_query = mysqli_real_escape_string($conn, $_GET['search_newsall']);
                    $sql = "SELECT * FROM news WHERE news_title LIKE '%" . $search_query . "%' limit " . $s_page . ",$e_page";

                } 
                
                $result= mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="col-lg-4">
                        <article class="position-relative h-100">
                            <div class="post-img position-relative overflow-hidden">
                                <img src="../pic/newspicture/<?php echo $row['news_img'] ?>" class="img-fluid" alt="">
                                <span class="post-date"><?php echo DateThai($row['news_date']) ?></span>
                            </div>

                            <a href="newsdetail.php?news_no=<?php echo $row['news_no'] ?>" class="post-content d-flex flex-column">
                                <h5 class="post-title">
                                    <?php echo $row['news_title'] ?>
                                </h5>
                                <hr>
                                <div class="readmore stretched-link">
                                    <span>อ่านเพิ่มเติม</span>
                                    <i class="bi bi-arrow-right"></i>
                                </div>
                            </a>
                        </article>
                    </div>
                <?php }
                ?>
            </div>

        </div>
    </section>
    <?php 
        page_navi(9,(isset($_GET['page']))?$_GET['page']:1,$e_page);
    ?>

    <?php function page_navi($total_item, $cur_page, $per_page = 9, $query_str = "", $min_page = 5)
    {
        $total_page = ceil($total_item / $per_page);
        $cur_page = (isset($cur_page)) ? $cur_page : 1;
        $diff_page = NULL;
        if ($cur_page > $min_page) {
            $diff_page = $total_page - $cur_page;
        }
        $limit_page = $min_page;
        $f_num_page = ($cur_page <= $min_page) ? 1 : (floor($cur_page / $min_page) * $min_page) + 1;
        if ($diff_page > $min_page) {
            $limit_page = ($min_page + $f_num_page) - 1;
        } else {
            if (isset($diff_page)) {
                $limit_page = $total_page;
            } else {
                $limit_page = $min_page;
            }
        }
        $show_page = ($total_page <= $min_page) ? $total_page : $limit_page;
        $l_num_page = 1;
        $prev_page = $cur_page - 1;
        $next_page = $cur_page + 1;
        $temp_query_str = $query_str;
        $query_str = "";
        if ($temp_query_str && is_array($temp_query_str) && count($temp_query_str) > 0) {
            array_pop($temp_query_str);
            $query_str = http_build_query($temp_query_str);
            if ($query_str != "") {
                $query_str = "?" . $query_str;
            }
        }
        $mark_char = ($query_str != "") ? "&" : "?"; ?>
        <section class="blog-pagination">
            <div class="container">
                <div class="d-flex justify-content-center">
                    <ul>
                        <li><a href="<?php echo $query_str.$mark_char.'page=1' ?>"><i class="bi bi-chevron-double-left"></i></a></li>
                        <li <?php echo (($cur_page==1)?'disabled':'') ?>><a href="<?php echo $query_str.$mark_char.'page='.$prev_page ?>"><i class="bi bi-chevron-left"></i></a></li>
                        <?php
                            for ($i = $f_num_page; $i<=$show_page;$i++) { 
                                echo '<li>
                                    <a href="'.$query_str.$mark_char.'page='.$i.'" class="'.(($i==$cur_page)?"active":"").'">'.$i.'</a>
                                </li>';
                            }
                        ?>
                        <li><a href="<?php echo $query_str.$mark_char.'page='.$next_page ?>" <?php echo (($next_page>$total_page)?"disabled":"")?>><i class="bi bi-chevron-right"></i></a></li>
                        <li><a href="<?php echo $query_str.$mark_char.'page='.$total_page ?>"><i class="bi bi-chevron-double-right"></i></a></li>
                    </ul>
                    
                </div>
            </div>
        </section>
    <?php }

    ?>


    <?php
    include("footer.php");
    ?>
</body>