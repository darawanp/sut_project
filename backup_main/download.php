<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>ดาวน์โหลด - งานวิเทศสัมพันธ์ | มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน</title>

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
    <section class="download-header text-center">
        <div class="container">
            <div class="col-lg-12 col-12">
                <h1>ดาวน์โหลดเอกสาร</h1>
            </div>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <?php 
                $sql = "SELECT * FROM doc_category GROUP BY doc_cate_no";
                $result = mysqli_query($conn,$sql);
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row=mysqli_fetch_assoc($result)) { ?>
                        <div class="dow-title">
                            <h3><?php echo $row['doc_cate_name']; ?></h3>
                            <hr>
                            <div class="row gy-4">
                                    <?php
                                        $sqlSelect = "SELECT * FROM download WHERE doc_cate_no='".$row['doc_cate_no']."'";
                                        $query = mysqli_query($conn,$sqlSelect);
                                        while ($row2=mysqli_fetch_assoc($query)) { ?>
                                            <div class="col-lg-12 col-xl-6">
                                                <div class="dow-item d-flex align-items-center w-100 h-100">
                                                    <?php 
                                                    if ($row2['file_type']=='PDF') {
                                                        echo '<i class="bi bi-file-earmark-pdf-fill pdf-icon flex-shrink-0"></i>
                                                        <div><a href=document/'.$row2['file_path'].' target="_blank">'.$row2['file_name'].'</a></div>';
                                                    } elseif ($row2['file_type']=='Word') {
                                                        echo '<i class="bi bi-file-earmark-word-fill w-icon flex-shrink-0"></i>
                                                        <div><a href=document/'.$row2['file_path'].' target="_blank">'.$row2['file_name'].'</a></div>';
                                                    }elseif ($row2['file_type']=='Excel') {
                                                        echo '<i class="bi bi-file-earmark-excel-fill excel-icon flex-shrink-0"></i>
                                                        <div><a href=document/'.$row2['file_path'].' target="_blank">'.$row2['file_name'].'</a></div>';
                                                    }
                                                    ?>   
                                                </div>
                                            </div>
                                        <?php }
                                    ?>
                            </div>
                        </div>
                    <?php }
                }
            ?>
            

            

        </div>
    </section>
    



    <?php
        include("footer.php");
    ?>
</body>