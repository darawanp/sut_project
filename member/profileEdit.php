<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>แก้ไขโปรไฟล์ - งานวิเทศสัมพันธ์ | มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน</title>

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
    <link href="../assets/css/main.css" rel="stylesheet">
    <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
</head>

<body>
    <?php include("menu.php") ?>
    <main>
        <section class="about-header text-center">
            <div class="container">
                <div class="col-lg-12 col-12">
                    <h1>โปรไฟล์</h1>
                </div>
            </div>
        </section>

        <section class="section-padding">
            <div class="container">
                <?php
                $sql = "SELECT * FROM user INNER JOIN agency_university ag ON user.ag_id=ag.ag_id WHERE user.user_id='" . $_GET['user_id'] . "'";
                $query = mysqli_query($conn, $sql);
                $user = mysqli_fetch_assoc($query);
                ?>
                <div class="form">
                    <div class="row">
                        <div class="col-lg-6">
                            <h5 class="text-center mb-4">แก้ไขโปรไฟล์</h5>
                            <form action="profileUpdate.php" method="POST">
                                <?php
                                $user_id = $user['user_id'];
                                $ag_id = $user['ag_id'];
                                $username = $user['username'];
                                $password = $user['password'];
                                $name = $user['name'];
                                $lastname = $user['lastname'];
                                $email = $user['email'];
                                $phone = $user['phone'];
                                $tel = $user['tel'];
                                $agency_img = $user['agency_img'];
                                $agencyname_thai = $user['agencyname_thai'];
                                $agencyname_eng = $user['agencyname_eng'];
                                $abbreviation_thai = $user['abbreviation_thai'];
                                $abbreviation_eng = $user['abbreviation_eng'];
                                $campus = $user['campus'];
                                ?>
                                <div class="row mb-3 g-3">
                                    <input type="hidden" name="user_id" value="<?php echo $user_id ?>">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="username" class="form-control"
                                                placeholder="Username" value="<?php echo $username; ?>" disabled>
                                            <label>Username</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control"
                                                placeholder="Password" value="<?php echo $password; ?>" disabled>
                                            <label>Password</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="col-md-4 col-lg-3 form-label">ชื่อ-สกุล</label>
                                    <div class="input-group mb-2">
                                        <input name="name" type="text" class="form-control" placeholder="ชื่อ"
                                            value="<?php echo $name; ?>">
                                        <input name="lastname" type="text" class="form-control" placeholder="สกุล"
                                            value="<?php echo $lastname; ?>">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">E-mail</label>
                                    <input type="text" class="form-control" name="email" value="<?php echo $email ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">เบอร์โทรศัพท์</label>
                                    <input type="text" class="form-control" name="phone" value="<?php echo $phone ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">เบอร์ภายใน</label>
                                    <input type="text" class="form-control" name="tel" value="<?php echo $tel ?>">
                                </div>
                                <div class="text-center mb-4">
                                    <button type="submit" class="btn btn-success">บันทึก</button>
                                </div>
                            </form>
                        </div>

                        <div class="col-lg-6">
                            <h5 class="text-center mb-4">แก้ไขข้อมูลหน่วยงาน</h5>
                            <label class="form-label">รูปโลโก้หน่วยงาน</label>
                            <div class="text-center">
                                <img src="../pic/logo/<?php echo $agency_img ?>" class="img-fluid"
                                    style="padding:20px 150px;">
                            </div>
                            <form action="agencyUpdate.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="ag_id" value="<?php echo $ag_id ?>">
                                <div class="mb-3">
                                    <label class="form-label">ชื่อหน่วยงาน(ไทย)</label>
                                    <input type="text" class="form-control" name="agencyname_thai"
                                        value="<?php echo $agencyname_thai ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">ชื่อหน่วยงาน(อังกฤษ)</label>
                                    <input type="text" class="form-control" name="agencyname_eng"
                                        value="<?php echo $agencyname_eng ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="col-md-6 col-lg-6 form-label">อักษรย่อ(ไทย/อังกฤษ)</label>
                                    <div class="input-group mb-2">
                                        <input name="abbreviation_thai" type="text" class="form-control"
                                            value="<?php echo $abbreviation_thai; ?>">
                                        <input name="abbreviation_eng" type="text" class="form-control"
                                            value="<?php echo $abbreviation_eng; ?>">
                                    </div>
                                </div>
                                <div class="row mb-1" hidden>
                                    <label class="col-md-4 col-lg-3 col-form-label">วิทยาเขต</label>
                                    <div class="col-md-8 col-lg-9 mb-2">
                                        <select class="form-select" name="campus">
                                            <option selected>เลือกวิทยาเขต</option>
                                            <option value="1" <?php echo ($campus == "1" ? 'selected' : ''); ?>>
                                                ศูนย์กลางนครราชสีมา</option>
                                            <option value="2" <?php echo ($campus == "2" ? 'selected' : ''); ?>>
                                                วิทยาเขตขอนแก่น</option>
                                            <option value="3" <?php echo ($campus == "3" ? 'selected' : ''); ?>>
                                                วิทยาเขตสกลนคร</option>
                                            <option value="4" <?php echo ($campus == "4" ? 'selected' : ''); ?>>
                                                วิทยาเขตสุรินทร์</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="col-md-4 col-lg-3 form-label">Logo ใหม่</label>
                                    <div class="mb-2">
                                        <input type="file" name="agency_img" class="form-control"
                                            accept=".jpg,.jpeg,.png,.gif">
                                        <input type="hidden" name="old_picture_file" class="form-control"
                                            value="<?php echo $agency_img; ?>">
                                    </div>
                                </div>
                                <div class="text-center mb-4">
                                    <button type="submit" class="btn btn-success">บันทึก</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </section>
    </main>


    <?php include("footer.php") ?>
</body>