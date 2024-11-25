<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>ถาม&ตอบ - งานวิเทศสัมพันธ์ | มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน</title>

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
    <section class="qa-header section-bg text-center">
        <div class="container">
            <div class="col-lg-12 col-12">
                <h1 class="text-white" style="font-weight: 400; font-size: 48px;">
                    ถาม-ตอบ
                </h1>
            </div>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <div class="col-lg-10 col-12 text-center mx-auto">
                <h5 class="mb-5" style="font-weight:400; font-size:20px;">ถาม-ตอบ คำถามที่พบบ่อย เกี่ยวกับงานวิเทศสัมพันธ์ <br> มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน</h5>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <?php 
                        $sql = "SELECT * FROM qa";
                        $result = mysqli_query($conn,$sql);
                        if ($result && mysqli_num_rows($result) > 0) {
                            $i=1;
                            while ($row=mysqli_fetch_assoc($result)) { ?>
                                <div class="qa-item">
                                    <h3 class="qa-header" id="hd1">
                                        <i class="qa-icon bi bi-question-circle"></i>
                                        <div data-bs-toggle="collapse" data-bs-target="#qa<?php echo $row['QA_no']; ?>" aria-expanded="false" aria-controls="qa<?php echo $row['QA_no']; ?>">
                                            <button class="qa-button border-0" type="button">
                                                <?php echo $row['question']; ?>
                                            </button>
                                            <i class="qa-toggle bi bi-chevron-right"></i>
                                        </div>
                                    </h3>
                                    <div id="qa<?php echo $row['QA_no']; ?>" class="accordion-collapse collapse" aria-labelledby="hd1">
                                        <div class="qa-content rounded">
                                            <?php echo $row['answer']; ?>
                                        </div>
                                    </div>
                                </div>
                           <?php }
                        }
                    ?>
                    

                    
                </div>
            </div>
            

            
        </div>
    
        
    </section>


    <?php
        include("footer.php")
    ?>
</body>