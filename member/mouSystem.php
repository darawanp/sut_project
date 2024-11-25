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

    <section class="mou-header section-bg text-center">
        <div class="container">
            <div class="col-lg-12 col-12">
                <h1>ระบบบันทึกข้อมูลการลงนาม (MOI/MOU/MOA)</h1>
            </div>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <div class="col-lg-10 col-12 text-center mx-auto">
                <h5 class="mb-2" style="font-weight:400; font-size:22px;">ข้อมูลการลงนามนี้ดำเนินการโดย <span
                        style="color: #FF9900;"><?php echo $_SESSION['campus']; ?></span></h5>
                <h5 class="mb-4" style="font-weight:400; font-size:20px;">กรุณากรอกข้อมูลทั้งหมดให้ครบถ้วน<span
                        class="ms-2" style="color: red; font-size:25px;">!</span></h5>
            </div>

            <div class="form">
                <div class="row">
                    <form name="upfile" action="mouInsert.php" method="POST" enctype="multipart/form-data">
                        <?php
                        $dates_tr = date('Y-m-d');
                        $deptNameCo = null;
                        $Mo_type = null;
                        $department = null;
                        $deptType = null;
                        $depAddress = null;
                        $time_mou = null;
                        $CountyName = null;
                        $nameMou = null;
                        $dateStart = null;
                        $dateExpired = null;
                        $deptAciton = $_SESSION['agency'];
                        $signRmuti = null;
                        $signRmutiWitness = null;
                        $signCo = null;
                        $signCoWitness = null;
                        $objDesc = null;
                        $userDesc = null;
                        $renewal = null;
                        $renewaltime = null;
                        $ag_id = $_SESSION['ag_id'];
                        $gg_drive = null;
                        $goal_id = null;
                        ?>
                        <input type="hidden" name="dates_tr" value="<?php echo $dates_tr; ?>">
                        <div hidden>
                            <input type="text" name="ag_id" value="<?php echo $ag_id; ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">ชื่อบันทึกความร่วมมือ</label>
                            <input type="text" class="form-control" name="nameMou" value="<?php echo $nameMou; ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ชื่อหน่วยงานร่วมลงนาม</label>
                            <input type="text" class="form-control" name="deptNameCo"
                                value="<?php echo $deptNameCo; ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ประเภทความร่วมมือ</label>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="Mo_type" value="1" <?php echo ($Mo_type == "1" ? 'checked' : ''); ?>>
                                <label class="form-check-label">
                                    บันทึกแสดงเจตจำนงทางวิชาการ (Memorandum of Intent: MOI)
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="Mo_type" value="2" <?php echo ($Mo_type == "2" ? 'checked' : ''); ?>>
                                <label class="form-check-label">
                                    บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding: MOU)
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="Mo_type" value="3" <?php echo ($Mo_type == "3" ? 'checked' : ''); ?>>
                                <label class="form-check-label">
                                    บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement: MOA)
                                </label>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <label class="form-label">หน่วยงาน/สถาบัน</label>
                            <div class="d-flex">
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="department" value="1" <?php echo ($department == "1" ? 'checked' : ''); ?>>
                                    <label class="form-check-label">
                                        ภายในประเทศ
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="department" value="2" <?php echo ($department == "2" ? 'checked' : ''); ?>>
                                    <label class="form-check-label">
                                        ต่างประเทศ โปรดระบุ ประเทศ: <input type="text" class="form-input"
                                            name="CountyName" value="<?php echo $CountyName; ?>">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <label class="form-label">ประเภทหน่วยงาน</label>
                            <div class="d-flex">
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="deptType" value="1" <?php echo ($deptType == "1" ? 'checked' : ''); ?>>
                                    <label class="form-check-label">
                                        สถาบันการศึกษา
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="deptType" value="2" <?php echo ($deptType == "2" ? 'checked' : ''); ?>>
                                    <label class="form-check-label">
                                        องค์กรภาครัฐ
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="deptType" value="3" <?php echo ($deptType == "3" ? 'checked' : ''); ?>>
                                    <label class="form-check-label">
                                        องค์กรภาคเอกชน
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-5">
                            <label class="form-label">ที่อยู่ของหน่วยงานที่ร่วมลงนาม</label>
                            <textarea name="depAddress" class="form-control"
                                style="height: 75px;"><?php echo $depAddress; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ระยะเวลาของบันทึกความร่วมมือ <input type="number"
                                    class="form-input col-md-2 text-center" name="time_mou"
                                    value="<?php echo $time_mou; ?>"> ปี</label>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="col-lg-6 d-flex me-2">
                                <label class="form-label col-md-3" style="padding-top: 5px;">วันที่ลงนาม</label>
                                <input type="date" class="form-control" name="dateStart"
                                    value="<?php echo $dateStart; ?>">
                            </div>
                            <div class="col-lg-6 d-flex ">
                                <label class="form-label col-md-3" style="padding-top: 5px;">วันที่หมดอายุ</label>
                                <input type="date" class="form-control" name="dateExpired"
                                    value="<?php echo $dateExpired; ?>">
                            </div>
                        </div>
                        <div class="mb-5">
                            <label class="form-label">เงื่อนไขการต่ออายุ</label>
                            <div class="d-flex">
                                <div class="col-lg-6">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" style="margin-left: 4.75rem;"
                                            name="renewal" value="1" <?php echo ($renewal == "1" ? 'checked' : ''); ?>>
                                        <label class="form-check-label">
                                            ต่ออายุอัตโนมัติ ทุก 3 ปี นับจากวันที่ลงนาม
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="renewal" value="2" <?php echo ($renewal == "2" ? 'checked' : ''); ?>>
                                        <label class="form-check-label">
                                            ต่ออายุอัตโนมัติ ทุก 5 ปี นับจากวันที่ลงนาม
                                        </label>
                                    </div>
                                </div>

                            </div>
                            <div class="d-flex">
                                <div class="col-lg-6">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" style="margin-left: 4.75rem;"
                                            name="renewal" value="3" <?php echo ($renewal == "3" ? 'checked' : ''); ?>>
                                        <label class="form-check-label col-lg-8">
                                            ต่ออายุอัตโนมัติ <input type="number"
                                                class="form-input col-md-2 text-center" name="renewaltime"
                                                value="<?php echo $renewaltime; ?>"> ปี นับจากวันที่ลงนาม
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="renewal" value="4" <?php echo ($renewal == "4" ? 'checked' : ''); ?>>
                                        <label class="form-check-label">
                                            จัดทําฉบับใหม่ (ภายหลังการหารือทั้งสองฝ่าย)
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div hidden>
                            <label class="form-label col-lg-4" style="padding-top: 5px;">หน่วยงาน มทร.อีสาน
                                ที่ดำเนินการ</label>
                            <input type="text" class="form-control" name="deptAciton"
                                value="<?php echo $deptAciton; ?>">
                        </div>
                        <div class="mb-5">
                            <label class="form-label">เป้าประสงค์การลงนามความร่วมมือ</label>
                            <?php
                            $sqlgoal = "SELECT * FROM goal_type GROUP BY goalty_title ORDER BY goalty_id ASC";
                            $query = mysqli_query($conn, $sqlgoal);
                            while ($row = mysqli_fetch_assoc($query)) { ?>
                                <div class="form-check mb-1">
                                    <i class="bx bxs-chevron-down-circle"
                                        style="font-size: 20px; margin-left: 1.5rem; margin-top: .40em;"></i>
                                    <label class="form-check-label">
                                        <?php echo $row['goalty_title']; ?>
                                    </label>
                                </div>
                                <?php
                                $sqlgoaldeail = "SELECT * FROM goal WHERE goalty_id='" . $row['goalty_id'] . "'";
                                $result = mysqli_query($conn, $sqlgoaldeail);
                                while ($row2 = mysqli_fetch_assoc($result)) { ?>
                                    <div id="select" class="form-check">
                                        <div class="d-flex">
                                            <input type="checkbox" class="form-check-input col-md-2" name="goal_id[]"
                                                value="<?php echo $row2['goal_id']; ?>" <?php echo ($goal_id == $row2['goal_id'] ? 'checked' : ''); ?>>
                                            <label class="form-check-label">
                                                <?php echo $row2['goal_detail']; ?>
                                            </label>
                                        </div>
                                    </div>
                                <?php }
                                ?>

                            <?php }
                            ?>


                        </div>
                        <div class="mb-5">
                            <label class="form-label">วัตถุประสงค์ของความร่วมมือ</label>
                            <textarea name="objDesc" class="form-control"
                                style="height: 150px;"><?php echo $objDesc; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label col-lg-3" style="padding-top: 5px;">ผู้ลงนาม (ผ่าย
                                มทร.อีสาน)</label>
                            <textarea name="signRmuti" class="form-control"
                                style="height: 50px;"><?php echo $signRmuti; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label col-lg-3" style="padding-top: 5px;">พยาน (ผ่าย มทร.อีสาน)</label>
                            <textarea name="signRmutiWitness" class="form-control"
                                style="height: 50px;"><?php echo $signRmutiWitness; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label col-lg-3" style="padding-top: 5px;">ผู้ลงนาม (ผ่ายพันธมิตร)</label>
                            <textarea name="signCo" class="form-control"
                                style="height: 50px;"><?php echo $signCo; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label col-lg-3" style="padding-top: 5px;">พยาน (ผ่ายพันธมิตร)</label>
                            <textarea name="signCoWitness" class="form-control"
                                style="height: 50px;"><?php echo $signCoWitness; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label col-lg-3">ผู้ให้ข้อมูล</label>
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <label style="padding-left: 25px;" class="col-md-2">ชื่อ-นามสกุล</label>
                                    <input type="text" class="form-input col-lg-9" name="infor_name">
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <label style="padding-left: 25px;" class="me-2 col-lg-5">ตำแหน่ง</label>
                                    <input type="text" class="form-input col-lg-6" name="infor_position">
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <label class="me-2 col-lg-4">สังกัด</label>
                                    <input type="text" class="form-input col-md-6" name="infor_belong">
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <label style="padding-left: 25px;" class="me-2 col-lg-5">เบอร์โทรศัพท์ภายใน</label>
                                    <input type="text" class="form-input col-lg-6 me-4" name="infor_tel">
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <label class="me-2 col-lg-4">เบอร์โทรศัพท์มือถือ</label>
                                    <input type="text" class="form-input col-lg-6" name="infor_phone">
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <label style="padding-left: 25px;" class="me-2 col-lg-5">E-Mail</label>
                                    <input type="text" class="form-input col-lg-6 me-4" name="infor_email">
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <label class="me-2 col-lg-4">Line ID</label>
                                    <input type="text" class="form-input col-lg-6" name="infor_line">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mb-3 mt-5">
                            <label class="form-label col-lg-4" style="padding-top: 5px;">แนบไฟล์(MOI/MOU/MOA) <span
                                    style="color:red;">*เฉพาะไฟล์ PDF</span></label>
                            <input type="file" name="file_path" class="form-control" required>
                        </div>
                        <div class="d-flex mb-4">
                            <label class="form-label col-lg-5" style="padding-top: 5px;">แนบลิงค์ Google Drive /ข่าว
                                ภาพร่วมพิธีลงนาม</label>
                            <input type="text" name="gg_drive" class="form-control" value="<?php echo $gg_drive; ?>">
                        </div>
                        <div class="text-center mt-5 mb-2">
                            <button type="submit" class="btn btn-success">บันทึกข้อมูล</button>
                            <button type="reset" class="btn btn-warning">ล้างข้อมูล</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


    <?php
    include("footer.php")
        ?>
</body>