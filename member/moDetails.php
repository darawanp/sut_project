<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>รายละเอียดของข้อมูลการลงนาม - งานวิเทศสัมพันธ์ | มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน</title>

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
            <?php
            $sql = "SELECT * FROM mou m INNER JOIN agency_university ag WHERE m.ag_id=ag.ag_id";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result)
                ?>
            <div class="col-lg-12 col-12">
                <h5>ข้อมูลการทำความร่วมมือ</h5>
                <h1><?php echo $row['agencyname_thai'] ?></h1>
            </div>
        </div>
    </section>

    <section class="mou-area">
        <div class="container">
            <?php
            $sqlSelect = "SELECT * FROM mou WHERE mouid='" . $_GET['mouid'] . "'";
            $query = mysqli_query($conn, $sqlSelect);
            $row2 = mysqli_fetch_assoc($query);

            $deptNameCo = $row2['deptNameCo'];
            $nameMou = $row2['nameMou'];
            $Mo_type = $row2['Mo_type'];
            $department = $row2['department'];
            $deptType = $row2['deptType'];
            $depAddress = $row2['depAddress'];
            $time_mou = $row2['time_mou'];
            $CountyName = $row2['CountyName'];
            $dateStart = $row2['dateStart'];
            $dateExpired = $row2['dateExpired'];
            $signRmuti = $row2['signRmuti'];
            $signRmutiWitness = $row2['signRmutiWitness'];
            $signCo = $row2['signCo'];
            $signCoWitness = $row2['signCoWitness'];
            $objDesc = $row2['objDesc'];
            $gg_drive = $row['gg_drive'];
            $file_path = $row2['file_path'];

            $goal_id = $row2['goal_id'];
            $goalall = explode(",", $goal_id);
            $goal_category = [
                'สอดคล้องกับตามพันธกิจ' => [
                    ['id' => 1, 'name' => 'การสร้างและพัฒนาศักยภาพผู้เรียนที่เน้นการเรียนการสอนควบคู่กับการปฏิบัติการจริงเพื่อพัฒนาสมรรถนะและทักษะระดับสูงในการทํางาน มีความรู้และความเชี่ยวชาญด้านเทคโนโลยีให้สามารถนําองค์ความรู้ไปประยุกต์เพื่อสร้างนวัตกรรม พัฒนาผลิตภัณฑ์ และบริการสังคม'],
                    ['id' => 2, 'name' => 'การสร้างนวัตกรรมจากงานวิจัย เพื่อนําไปใช้ในเชิงพาณิชย์หรือสาธารณประโยชน์ เพื่อสร้างมูลค่าเพิ่มตลอดห่วงโซ่มูลค่าในภาคอุตสาหกรรมการผลิต การค้า และการบริการ'],
                    ['id' => 3, 'name' => 'การส่งเสริมบทบาทความร่วมมือ กับ ภาครัฐ และ ภาคเอกชน ทั้งในประเทศและต่างประเทศเพื่อสนับสนุนและพัฒนาเทคโนโลยีและนวัตกรรม'],
                    ['id' => 4, 'name' => 'การสนองโครงการอันเนื่องมาจากพระราชดําริ และทํานุบํารุงศิลปวัฒนธรรม เพื่อพัฒนาท้องถิ่น สังคม สู่ความยั่งยืน']
                ],
                'สอดคล้องกับประเด็นแผนยุทธศาสตร์' => [
                    ['id' => 5, 'name' => 'ประเด็นยุทธศาสตร์ ที่ 1 : พลิกโฉมการสอน สร้างนักปฏิบัติ นวัตกรรมและการเป็นผู้ประกอบการ'],
                    ['id' => 6, 'name' => 'ประเด็นยุทธศาสตร์ ที่ 2 : ยกระดับการทํางานวิจัย สร้างเทคโนโลยีและนวัตกรรมสู่เชิงพาณิชย์'],
                    ['id' => 7, 'name' => 'ประเด็นยุทธศาสตร์ ที่ 3 : บูรณาการความร่วมมือกับพหุภาคี ทั้งในประเทศและต่างประเทศ'],
                    ['id' => 8, 'name' => 'ประเด็นยุทธศาสตร์ ที่ 4 : เปลี่ยนผ่านระบบการบริหารองค์กรสู่ยุคดิจิทัล และเชื่อมโยงสู่การพัฒนาที่ยั่งยืน'],
                ],
                'สอดคล้องกับจุดเน้น (Cluster)' => [
                    ['id' => 9, 'name' => 'Cluster ที่ 1) Logistics ประกอบด้วย ระบบราง (Rail System), อากาศยาน (Aviation), โลจิสติกส์ (Logistics), ยานยนต์ไฟฟ้า/ พลังงานที่ยั่งยืน (Electric Vehicle, EV /Sustainable Energy, SE) และ หุ่นยนต์/ระบบอัตโนมัติ/เอไอ (Robotics/Automation/AI)'],
                    ['id' => 10, 'name' => 'Cluster ที่ 2) Agriculture Technology & Food Security ประกอบด้วย การเปลี่ยนแปลงสภาพภูมิอากาศ (Climate Change (Carbon Neutrality, Net Zero GHG Emission)) , วิกฤตทางอาหาร (Food Crisis(Organic Food, Functional Food, Future Food)) และ เกษตรสมัยใหม่ (Agriculture (Organic, Smart Farm, Offseason, Water Management))'],
                    ['id' => 11, 'name' => 'Cluster ที่ 3) Health & Tourism ประกอบด้วย สุขภาพแบบองค์รวม (Wellness (Herbal Product, Cosmetic Spa, Alternative Medicine for Aging Society, Medical Tools)) และ การท่องเที่ยว (Tourism)']
                ]
            ]
                ?>
            <div class="custom-text-box">
                <div class="row">
                    <div class="col-lg-10">
                        <h3><?php echo $nameMou ?></h3>
                    </div>
                    <div class="col-lg-2">
                        <h4 class="text-end">ระยะเวลา</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-10">
                        <h4>
                            <?php
                            if ($Mo_type = 1) {
                                echo 'บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent: MOI)';
                            } elseif ($Mo_type = 2) {
                                echo 'บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding: MOU)';
                            } elseif ($Mo_type = 3) {
                                echo 'บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement: MOA)';
                            }
                            ?>
                        </h4>
                    </div>
                    <div class="col-lg-2">
                        <h3 class="text-end"><?php echo $time_mou ?> ปี</h3>
                    </div>
                </div>


                <hr>
                <div style="padding:10px 100px;">
                    <h5>ข้อมูลหน่วยงานร่วมลงนาม</h5>
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <h6>ชื่อหน่วยงาน</h6>
                            <h6>ประเภท</h6>
                            <h6>หน่วยงาน/สถาบัน</h6>
                            <h6>ที่อยู่ของหน่วยงาน</h6>
                        </div>
                        <div class="col-lg-1" id="moudetail">
                            <h5>:</h5>
                            <h5>:</h5>
                            <h5>:</h5>
                            <h5>:</h5>
                        </div>
                        <div class="col-lg-6" id="moudetail">
                            <h6><?php echo $deptNameCo ?></h6>
                            <h6>
                                <?php
                                if ($deptType = 1) {
                                    echo 'สถาบันการศึกษา';
                                } elseif ($deptType = 2) {
                                    echo 'องค์กรภาครัฐ';
                                } elseif ($deptType = 3) {
                                    echo 'องค์กรภาคเอกชน';
                                }
                                ?>
                            </h6>
                            <h6>
                                <?php
                                if ($department = 1) {
                                    echo 'ภายในประเทศ';
                                } elseif ($department = 2) {
                                    echo 'ต่างประเทศ  ประเทศ' . $CountyName . '';
                                }
                                ?>
                            </h6>
                            <h6><?php echo $depAddress ?></h6>
                        </div>
                        <div class="col-lg-2" id="moudetail">
                            <a href="../document/mo_pdf/<?php echo $file_path ?>" class="btn-pdf row mb-2"
                                target="_blank">
                                <i class="bi bi-file-earmark-pdf-fill"></i>
                                <div class="text-center">ไฟล์การลงนาม</div>
                            </a>
                            <a href="<?php echo $gg_drive ?>" class="btn-link row" target="_blank">
                                <i class='bx bx-link'></i>
                                <div class="text-center">ลิงค์ข่าว/ภาพ</div>
                            </a>
                        </div>
                    </div>

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
                    <h5>รายละเอียดการลงนาม</h5>
                    <div class="row">
                        <div class="col-lg-4">
                            <h6>วันที่ลงนาม</h6>
                            <h6>วันที่หมดอายุ</h6>
                        </div>
                        <div class="col-lg-1" id="moudetail">
                            <h5>:</h5>
                            <h5>:</h5>
                        </div>
                        <div class="col-lg-7" id="moudetail">
                            <h6><?php echo DateThai($dateStart) ?></h6>
                            <h6><?php echo DateThai($dateExpired) ?></h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <h6>วัตถุประสงค์ความร่วมมือ</h6>
                        </div>
                        <div class="col-lg-1" id="moudetail">
                            <h5>:</h5>
                        </div>
                        <div class="col-lg-7" id="moudetail">
                            <h6><?php echo $objDesc ?></h6>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-4">
                            <h6>เป้าประสงค์การลงนามความร่วมมือ</h6>
                        </div>
                        <div class="col-lg-1" id="moudetail">
                            <h5>:</h5>
                        </div>
                        <div class="col-lg-7" id="moudetail">
                            <?php
                            foreach ($goal_category as $typename => $options) {
                                echo '<span>' . $typename . '</span>';
                                foreach ($options as $option) {
                                    if ($option['id'] == in_array($option['id'], $goalall)) {
                                        echo '<h6 style="margin-left:30px !important;">' . $option['name'] . '</h6>';
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <hr>
                <div style="padding:10px 100px;">
                    <div class="row mt-3">
                        <div class="col-lg-6 text-center">
                            <h6>ผู้ลงนาม (ฝ่าย มทร.อีสาน) :</h6>
                            <div id="moudetail" style="margin-left:50px;">
                                <h6 class="mb-3"><?php echo $signRmuti ?></h6>
                            </div>
                            <h6>พยาน (ฝ่าย มทร.อีสาน) :</h6>
                            <div id="moudetail" style="margin-left:50px;">
                                <h6><?php echo $signRmutiWitness ?></h6>
                            </div>
                        </div>
                        <div class="col-lg-6 text-center" id="moudetail">
                            <h6 style="font-weight:500;">ผู้ลงนาม (ฝ่ายพันธมิตร) :</h6>
                            <h6 class="mb-3"><?php echo $signCo ?></h6>
                            <h6 style="font-weight:500;">พยาน (ฝ่ายพันธมิตร) :</h6>
                            <h6><?php echo $signCoWitness ?></h6>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </section>

    <section class="mou-area">
        <div class="container">
            <h5 class="text-center">กิจกรรมภายใต้การลงนาม</h5>
            <hr>
            <div class="swiper">
                <div class="swiper-wrapper">
                    <?php
                    $sqlact = "SELECT * FROM activity ag INNER JOIN type_activity t WHERE ag.typeAct_no=t.typeAct_no AND mouid='" . $_GET['mouid'] . "' ORDER BY act_dateStart ASC";
                    $queryact = mysqli_query($conn, $sqlact);
                    $numrow = mysqli_num_rows($queryact);
                    if ($numrow > 0) {
                        while ($act = mysqli_fetch_assoc($queryact)) { ?>
                            <div class="swiper-slide">
                                <div class="act-item">
                                    <div class="col-lg-4">
                                        <div class="info-box">
                                            <h4><?php echo $act['act_name'] ?></h4>
                                            <p>ประเภท : <?php echo $act['typeAct_name'] ?> <br>
                                                <?php echo DateThai($act['act_dateStart']) . " - " . DateThai($act['act_dateEnd']); ?>
                                            </p>
                                            <a href="" class="mou-btn">ดูเพิ่มเติม</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        <?php }
                    } else {
                        echo '<div class="text-center"><h5>ยังไม่มีกิจกรรม</h5></div>';
                    }
                    ?>
                </div>
                <div class="swiper-pagination"></div>

            </div>
        </div>
    </section>

    <?php
    include("footer.php")
        ?>
</body>