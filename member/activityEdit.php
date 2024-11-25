<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>แก้ไขกิจกรรมภายใต้การลงนาม - งานวิเทศสัมพันธ์ | มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน</title>

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
    <?php include("menuN.php") ?>

    <section class="mou-header section-bg text-center">
        <div class="container">
            <div class="col-lg-12 col-12">
                <h1>แก้ไขกิจกรรมภายใต้การลงนาม</h1>
            </div>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <form action="activityUpdate.php" method="POST">
                <?php
                    $sql = "SELECT * FROM activity WHERE act_id='".$_GET['act_id']."'";
                    $query = mysqli_query($conn,$sql);
                    $act = mysqli_fetch_assoc($query);

                    $mouid = $act['mouid'];
                    $act_name = $act['act_name'];
                    $act_dateStart = $act['act_dateStart'];
                    $act_dateEnd = $act['act_dateEnd'];
                    $act_details = $act['act_details'];
                    $act_place = $act['act_place'];
                    $gg_drive = $act['gg_drive'];
                    $typeAct_no = $act['typeAct_no'];
                    $typeAct_custom = $act['typeAct_custom'];

                    $opall = $act['op'];
                    $op = explode(",",$opall);
                    
                    $inforall = $act['infor'];
                    $infor = explode(",",$inforall)
                ?>
                <div class="col-lg-10 col-12 text-center mx-auto">
                    <h5 class="mb-3" style="font-weight:400; font-size:22px;">กิจกรรมภายใต้การลงนามนี้ดำเนินการโดย <span
                            style="color: #FF9900;"><?php echo $_SESSION['campus']; ?></span></h5>
                    <input type="hidden" name="ag_id" value="<?php echo $_SESSION['ag_id'] ?>">
                    <div class="d-flex justify-content-center">
                        <h5 style="font-weight:400; font-size:22px;" class="me-2"> ใน</h5>
                        <div class="col-lg-6">
                            <select name="mouid" class="form-select mb-2">
                                <option selected>-เลือกบันทึกการลงนามที่ดำเนินกิจกรรม-</option>
                                <?php
                                $sqlSelect = "SELECT * FROM mou WHERE ag_id='" . $_SESSION['ag_id'] . "'";
                                $result = mysqli_query($conn, $sqlSelect);
                                $i = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $selected = $mouid == $row['mouid'] ? 'selected="selected"' : '';
                                    echo
                                        '<option value="' . $row['mouid'] . '" ' . $selected . '>' . $i++ . ' : ' . $row['nameMou'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                    </div>
                    <h5 class="mb-4" style="font-weight:400; font-size:20px;">กรุณากรอกข้อมูลทั้งหมดให้ครบถ้วน<span
                            class="ms-2" style="color: red; font-size:25px;">!</span></h5>
                </div>
                <div class="form">
                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label mb-2">ชื่อหน่วยงานและรายละเอียดผู้ดำเนินกิจกรรมหลัก
                                (หน่วยงานต้นเรื่องใน มทร.อีสาน)</label>
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <label style="padding-left: 25px;" class="me-2 col-lg-5">ผู้ดำเนินการ
                                        ชื่อ-นามสกุล</label>
                                    <input type="text" class="form-input col-lg-6 me-4" name="op_name" value="<?php echo $op[0] ?>">
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <label class="me-2 col-lg-4">ตำแหน่ง</label>
                                    <input type="text" class="form-input col-lg-6" name="op_position" value="<?php echo $op[1] ?>">
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <label style="padding-left: 25px;" class="me-2 col-lg-5">เบอร์โทรศัพท์ภายใน</label>
                                    <input type="text" class="form-input col-lg-6 me-4" name="op_tel" value="<?php echo $op[2] ?>">
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <label class="me-2 col-lg-4">เบอร์โทรศัพท์มือถือ</label>
                                    <input type="text" class="form-input col-lg-6" name="op_phone" value="<?php echo $op[3] ?>">
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <label style="padding-left: 25px;" class="me-2 col-lg-5">E-Mail</label>
                                    <input type="text" class="form-input col-lg-6 me-4" name="op_email" value="<?php echo $op[4] ?>">
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <label class="me-2 col-lg-4">Line ID</label>
                                    <input type="text" class="form-input col-lg-6" name="op_line" value="<?php echo $op[5] ?>">
                                </div>
                                <div class="col-lg-12 mb-2">
                                    <label style="padding-left: 25px;"
                                        class="me-2 col-lg-3">สำนักวิชา/ศูนย์/สถาบัน/คณะ</label>
                                    <input type="text" class="form-input col-lg-6 me-4" name="op_faculty" value="<?php echo $op[6] ?>">
                                </div>
                                <div class="col-lg-12 mb-4">
                                    <label style="padding-left: 25px;" class="me-2 col-lg-3">สาขาวิชา/ฝ่าย</label>
                                    <input type="text" class="form-input col-lg-6 me-4" name="op_programs" value="<?php echo $op[7] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label mb-2">ประเภทกิจกรรม</label>
                            <div class="row">
                                <?php
                                $sqlact = "SELECT * FROM type_activity";
                                $result2 = mysqli_query($conn, $sqlact);
                                if ($result2 && mysqli_num_rows($result2) > 0) {
                                    while ($row2 = mysqli_fetch_assoc($result2)) {
                                        if ($row2['typeAct_name'] != 'อื่นๆ โปรดระบุ...') { ?>
                                            <div class="col-lg-6">
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" name="typeAct_no"
                                                        value="<?php echo $row2['typeAct_no']; ?>" <?php echo ($typeAct_no == $row2['typeAct_no'] ? 'checked' : ''); ?>>
                                                    <label class="form-check-label">
                                                        <?php echo $row2['typeAct_name']; ?>
                                                    </label>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="col-lg-6">
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" name="typeAct_no"
                                                        value="<?php echo $row2['typeAct_no']; ?>" <?php echo ($typeAct_no == $row2['typeAct_no'] ? 'checked' : ''); ?>>
                                                    <label class="form-check-label">
                                                        <?php echo $row2['typeAct_name']; ?> <input type="text" class="form-input"
                                                            name="typeAct_custom">
                                                    </label>
                                                </div>
                                            </div>
                                        <?php }
                                    }
                                } ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label me-2">ชื่อกิจกรรม/โครงการ</label>
                            <input type="text" class="form-control me-4" name="act_name" value="<?php echo $act_name ?>">
                        </div>
                        <div class="meb-3">
                            <label class="form-label">รายละเอียดกิจกรรม/โครงการ</label>
                            <textarea name="act_details" class="form-control" style="height:150px;"><?php echo $act_details ?></textarea>
                        </div>
                        <div class="mb-3 mt-3">
                            <label class="form-label">ระบุช่วงเวลาที่ดำเนินการ</label>
                            <div class="d-flex">
                                <label style="padding-left: 25px; padding-top: 5px;">ตั้งแต่วันที่</label>
                                <input type="date" class="form-input ms-2" name="act_dateStart" value="<?php echo $act_dateStart ?>">
                                <input type="date" class="form-input ms-2" name="act_dateEnd" value="<?php echo $act_dateEnd ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">สถานที่จัดกิจกรรม</label>
                            <textarea name="act_place" class="form-control" style="height: 75px;"><?php echo $act_place ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">แนบลิงค์ Google Drive รวมภายถ่ายการทำกิจกรรม</label>
                            <input type="text" class="form-control" name="gg_drive" value="<?php echo $gg_drive ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ผู้ให้ข้อมูล</label>
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <label style="padding-left: 25px;" class="col-md-2">ชื่อ-นามสกุล</label>
                                    <input type="text" class="form-input col-lg-9" name="infor_name" value="<?php echo $infor[0] ?>">
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <label style="padding-left: 25px;" class="me-2 col-lg-5">ตำแหน่ง</label>
                                    <input type="text" class="form-input col-lg-6" name="infor_position" value="<?php echo $infor[1] ?>">
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <label class="me-2 col-lg-4">สังกัด</label>
                                    <input type="text" class="form-input col-md-6" name="infor_belong" value="<?php echo $infor[2] ?>">
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <label style="padding-left: 25px;" class="me-2 col-lg-5">เบอร์โทรศัพท์ภายใน</label>
                                    <input type="text" class="form-input col-lg-6 me-4" name="infor_tel" value="<?php echo $infor[3] ?>">
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <label class="me-2 col-lg-4">เบอร์โทรศัพท์มือถือ</label>
                                    <input type="text" class="form-input col-lg-6" name="infor_phone" value="<?php echo $infor[4] ?>">
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <label style="padding-left: 25px;" class="me-2 col-lg-5">E-Mail</label>
                                    <input type="text" class="form-input col-lg-6 me-4" name="infor_email" value="<?php echo $infor[5] ?>">
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <label class="me-2 col-lg-4">Line ID</label>
                                    <input type="text" class="form-input col-lg-6" name="infor_line" value="<?php echo $infor[6] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4 mb-2">
                            <button type="submit" class="btn btn-success">บันทึกข้อมูล</button>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </section>


    <?php
    include("footerN.php")
        ?>
</body>