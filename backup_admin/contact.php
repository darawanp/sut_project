<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>ข้อมูลติดต่อ - Admin Management</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="../assets/img/RMUTI.png" rel="icon">
    <link href="../assets/img/RMUTI2.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" crossorigin rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="../assets/css/style.css" rel="stylesheet">

    <!-- SummerNote -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
</head>

<body>
    <?php include("menu_admin.php") ?>

    <main id="main" class="main">

        <div class="pagetitle text-center">
            <h2>ติดต่อ</h2>
        </div>

        <section class="section">
            <?php
            $sql = "SELECT * FROM contact";
            $result = $conn->query($sql);
            $row = mysqli_fetch_array($result);

            ?>
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="info-box mb-4">
                        <i class="bi bi-geo-alt-fill"></i>
                        <h4>สถานที่ติดต่อ</h4>
                        <p style="padding:10px 130px;"><?php echo $row['contact_address']; ?></p>
                        <p style="padding:10px 50px;"><?php echo $row['contact_university']; ?></p>
                    </div>

                    <div class="row">
                        <div class="col-lg-7">
                            <div class="info-box contact-box mb-4 h-100">
                                <i class="bi bi-telephone-fill"></i>
                                <h4>เบอร์โทรศัพท์</h4>
                                <p style="padding:10px 50px;"><?php echo $row['contact_tel']; ?></p>
                            </div>
                        </div>

                        <div class="col-lg-5">
                            <div class="info-box contact-box mb-4 h-100">
                                <i class="bi bi-envelope-fill"></i>
                                <h4>อีเมล</h4>
                                <p style="padding:10px 40px;"><?php echo $row['contact_email']; ?></p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-site text-center">
                            <h5 class="card-title">แก้ไขข้อมูลการติดต่อ</h5>
                        </div>

                        <?php

                        $sqlQuery = "SELECT * FROM contact WHERE contact_no=1";
                        $result = mysqli_query($conn, $sqlQuery);
                        $contact = mysqli_fetch_assoc($result);
                        ?>

                        <div class="card-body">
                            <form name="contactAdd" action="contactUpdate.php" class="row g-3" method="POST">
                                <input type="hidden" name="contact_no" value="<?php echo $contact['contact_no']; ?>">
                                <div class="col-12">
                                    <label for="" class="form-label" style="margin-top: 20px;">ที่อยู่ :
                                        หน่วยงาน</label>
                                    <textarea name="contact_address" class="form-control"
                                        style="height: 75px;"><?php echo $contact_address = $contact['contact_address']; ?></textarea>
                                </div>
                                <div class="col-12">
                                    <label for="" class="form-label">ที่อยู่ : มหาวิทยาลัย</label>
                                    <textarea name="contact_university" class="form-control"
                                        style="height: 75px;"><?php echo $contact_university = $contact['contact_university']; ?></textarea>
                                </div>
                                <div class="col-12">
                                    <label for="" class="form-label">เบอร์โทรศัพท์</label>
                                    <input name="contact_tel" type="text" class="form-control"
                                        value="<?php echo $contact_tel = $contact['contact_tel']; ?>">
                                </div>
                                <div class="col-12">
                                    <label for="" class="form-label">อีเมล</label>
                                    <input name="contact_email" type="email" class="form-control"
                                        value="<?php echo $contact_email = $contact['contact_email']; ?>">
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success">บันทึก</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>


        </section>


    </main>




    <?php
    include("footer_admin.php")
        ?>

</body>