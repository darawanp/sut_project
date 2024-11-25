<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>แก้ไขโปรไฟล์ - Admin Management</title>
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
            <h2>แก้ไขโปรไฟล์</h2>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-site text-center">
                    <h5 class="card-title">ข้อมูลโปรไฟล์</h5>
                </div>

                <div class="card-body">
                    <form action="user_profileUpdate.php" method="POST">
                        <?php
                        $sqlQuery = "SELECT * FROM user INNER JOIN agency_university ag ON user.ag_id=ag.ag_id WHERE user.user_id='" . $_GET['user_id'] . "'";
                        $query = mysqli_query($conn, $sqlQuery);
                        $user = mysqli_fetch_assoc($query);

                        $user_id = $user['user_id'];
                        $username = $user['username'];
                        $password = $user['password'];
                        $name = $user['name'];
                        $lastname = $user['lastname'];
                        $email = $user['email'];
                        $phone = $user['phone'];
                        $tel = $user['tel'];
                        $ag_id = $user['ag_id'];
                        $user_type = $user['user_type'];
                        $status = $user['status'];
                        ?>
                        <div class="form">
                            <div class="row mb-4 g-3">
                                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input name="username" type="username" class="form-control"
                                            placeholder="Username" value="<?php echo $username; ?>">
                                        <label>Username</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input name="password" type="text" class="form-control" placeholder="Password"
                                            value="<?php echo $password; ?>">
                                        <label>Password</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-4 col-lg-3 col-form-label">ชื่อ-สกุล</label>
                                <div class="input-group mb-2">
                                    <input name="name" type="text" class="form-control" placeholder="ชื่อ"
                                        value="<?php echo $name; ?>">
                                    <input name="lastname" type="text" class="form-control" placeholder="สกุล"
                                        value="<?php echo $lastname; ?>">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-4 col-lg-3 col-form-label">อีเมล</label>
                                <div class="col-md-8 col-lg-9 mb-2">
                                    <input name="email" type="email" class="form-control" value="<?php echo $email; ?>">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-4 col-lg-3 col-form-label">เบอร์โทรศัพท์</label>
                                <div class="col-md-8 col-lg-9 mb-2">
                                    <input name="phone" type="text" class="form-control" value="<?php echo $phone; ?>">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-4 col-lg-3 col-form-label">เบอร์ภายใน</label>
                                <div class="col-md-8 col-lg-9 mb-2">
                                    <input name="tel" type="text" class="form-control" value="<?php echo $tel; ?>">
                                </div>
                            </div>

                            <div class="row mb-2">
                                <label class="col-md-4 col-lg-3 col-form-label">หน่วยงาน</label>
                                <div class="col-md-8 col-lg-9 mb-2">
                                    <select class="form-select" name="ag_id">
                                        <option selected>เลือกหน่วยงานที่สังกัด</option>
                                        <?php
                                        $statusList = array("1" => "มทร.อีสาน", "2" => "มทร.ขอนแก่น", "3" => "มทร.สกลนคร", "4" => "มทร.สุรินทร์");
                                        $sqlSelect = "SELECT * FROM agency_university";
                                        $result = mysqli_query($conn, $sqlSelect);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $selected = $ag_id == $row['ag_id'] ? 'selected="selected"' : '';
                                            echo
                                                '<option value="' . $row['ag_id'] . '" ' . $selected . '>' . $statusList[$row['campus']] . ' : ' . $row['agencyname_thai'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success">บันทึก</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


        </section>
    </main>


    <?php include("footer_admin.php") ?>
</body>