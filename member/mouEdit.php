<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>แก้ไขข้อมูลบันทึกการลงนาม - งานวิเทศสัมพันธ์ | มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน</title>

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
                <h1>แก้ไขบันทึกข้อมูลการลงนาม (MOI/MOU/MOA)</h1>
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
                    <form action="mouUpdate.php" method="POST" enctype="multipart/form-data">
                        <?php
                        $sql = "SELECT * FROM mou WHERE mouid='" . $_GET['mouid'] . "'";
                        $query = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($query);

                        $mouid = $row['mouid'];
                        $deptNameCo = $row['deptNameCo'];
                        $Mo_type = $row['Mo_type'];
                        $department = $row['department'];
                        $deptType = $row['deptType'];
                        $depAddress = $row['depAddress'];
                        $time_mou = $row['time_mou'];
                        $CountyName = $row['CountyName'];
                        $nameMou = $row['nameMou'];
                        $dateStart = $row['dateStart'];
                        $dateExpired = $row['dateExpired'];
                        $signRmuti = $row['signRmuti'];
                        $signRmutiWitness = $row['signRmutiWitness'];
                        $signCo = $row['signCo'];
                        $signCoWitness = $row['signCoWitness'];
                        $objDesc = $row['objDesc'];
                        $userDesc = $row['userDesc'];
                        $infor = explode(",",$userDesc);
                        $renewal = $row['renewal'];
                        $renewaltime = $row['renewaltime'];
                        $gg_drive = $row['gg_drive'];
                        $file_path = $row['file_path'];
                        $goalall = $row['goal_id'];

                        $goalcheck = explode(",",$goalall);
                        
                        $goal_category= [
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
                        <div class="mb-3">
                            <input type="hidden" name="mouid" value="<?php echo $mouid ?>">
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
                        <div class="mb-5">
                            <label class="form-label">เป้าประสงค์การลงนามความร่วมมือ</label>
                            <?php foreach($goal_category as $typename => $options): ?>
                                <div class="form-check mb-1">
                                    <i class="bx bxs-chevron-down-circle" style="font-size: 20px; margin-left: 1.5rem; margin-top: .40em;"></i>
                                    <label class="form-check-label">
                                        <?php echo $typename; ?>
                                    </label>
                                </div>
                                <?php foreach($options as $option): ?>
                                    <div id="select" class="form-check" >
                                        <div class="d-flex">
                                            <input type="checkbox" class="form-check-input col-md-2" name="goal_id[]" value="<?php echo $option['id']; ?>" 
                                                <?php echo in_array($option['id'], $goalcheck) ? 'checked' : ''; ?>>
                                            <label class="form-check-label">
                                                <?php echo $option['name']; ?>
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
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
                        <div class="d-flex mb-3 mt-5">
                            <label class="form-label col-lg-4" style="padding-top: 5px;">แนบไฟล์(MOI/MOU/MOA) <span
                                    style="color:red;">*เฉพาะไฟล์ PDF</span></label>
                            <input type="text" class="form-control" value="<?php echo basename($file_path); ?>"
                                readonly>
                            <input type="hidden" name="old_file_path"
                                value="<?php echo htmlspecialchars($file_path); ?>">
                            <label class="input-group-text btn btn-outline-secondary"
                                for="file_path">เลือกไฟล์ใหม่</label>
                            <input id="file_path" name="file_path" type="file" class="form-control"
                                style="display:none;">
                        </div>
                        <div class="d-flex mb-4">
                            <label class="form-label col-lg-5" style="padding-top: 5px;">แนบลิงค์ Google Drive /ข่าว
                                ภาพร่วมพิธีลงนาม</label>
                            <input type="text" name="gg_drive" class="form-control" value="<?php echo $gg_drive; ?>">
                        </div>
                        <div class="text-center mt-5 mb-2">
                            <button type="submit" class="btn btn-success">บันทึกข้อมูล</button>
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