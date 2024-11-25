<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>ติดต่อ - งานวิเทศสัมพันธ์ | มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน</title>

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
    <main>
        <section class="contact-header section-bg text-center">
            <div class="container">
                <div class="col-lg-12 col-12">
                    <h1 class="text-white" style="font-weight: 400; font-size: 48px;">
                        ข้อมูลติดต่อ
                    </h1>
                </div>

            </div>
        </section>

        <section class="section-padding">
            <div class="container">
                <?php
                    $sqlSelect = "SELECT * FROM contact";
                    $result2 = mysqli_query($conn,$sqlSelect);
                    $contact = mysqli_fetch_assoc($result2);
                ?>
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <div class="info-box mb-4">
                            <i class="bi bi-geo-alt-fill"></i>
                            <h4>สถานที่ติดต่อ</h4>
                            <p style="padding:10px 180px;">
                                <?php echo $contact['contact_address']; ?>
                            </p>
                            <p style="padding:10px 70px;">
                                <?php echo $contact['contact_university']; ?>
                            </p>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="info-box mb-4">
                                    <i class="bi bi-telephone-fill"></i>
                                    <h4>เบอร์โทรศัพท์</h4>
                                    <p>
                                        <?php echo $contact['contact_tel'] ?>
                                    </p>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="info-box mb-4">
                                    <i class="bi bi-envelope-fill"></i>
                                    <h4>อีเมล</h4>
                                    <p>
                                        <?php echo $contact['contact_email'] ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    <div class="col-lg-6 col-12 mb-5 mb-lg-0">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d61665.50852573528!2d102.0417471486328!3d14.987470600000005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31194b80019e1771%3A0xc6979e02d8d878c7!2z4Lih4Lir4Liy4Lin4Li04LiX4Lii4Liy4Lil4Lix4Lii4LmA4LiX4LiE4LmC4LiZ4LmC4Lil4Lii4Li14Lij4Liy4LiK4Lih4LiH4LiE4Lil4Lit4Li14Liq4Liy4LiZICjguKrguLjguKPguJnguLLguKPguLLguKLguJPguYwp!5e0!3m2!1sth!2sth!4v1721297545296!5m2!1sth!2sth" width="600" height="555" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>

                </div>

            </div>
        </section>

        <section class="contact-section">
            <div class="container">
                <hr>
                <div class="col-12 mx-auto">
                    <div class="contact-box">
                        <div class="contact-pic">
                            <img src="../assets/img/contact-logo.jpg" alt="">
                        </div>

                        <form class="custom-form contact-form" action="messageInsert.php" method="POST" role="form">
                            <?php
                            $MS_no = null;
                            $qa_username = null;
                            $qa_email = null;
                            $question = null;
                            $question_details = null;
                            ?>
                            <div class="row">
                                <input type="hidden" name="MS_no" value="<?php echo $MS_no; ?>">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <input type="name" name="qa_username" id="name" class="form-control" placeholder="ชื่อ-สกุล" required value="<?php echo $qa_username; ?>">
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <input type="email" name="qa_email" id="email" class="form-control" placeholder="อีเมล" required value="<?php echo $qa_email ?>">
                                </div>
                            </div>
                            <input type="text" name="question" class="form-control" placeholder="เรื่อง" required value="<?php echo $question; ?>">
                            <textarea name="question_details" rows="5" class="form-control"  placeholder="รายละเอียด" required value="<?php echo $question_details; ?>"></textarea>
                            <div class="text-center">
                                <button type="submit" >ส่งข้อความ</button>
                            </div>
                        </form>
                        
                    </div>
                </div>
                
            </div>
        </section>
    </main>

    <?php
        include("footer.php")
    ?>
</body>

