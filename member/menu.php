<?php require_once '../database/connect.php';
session_start();
$menu=basename($_SERVER['PHP_SELF']);
?>
<header class="site-header"> <!-- แถบข้อมูลหน่วยงานและข้อมูลติดต่อ -->
    <div class="container">
        <div class="row">
            <?php 
                $sqlcon = "SELECT * FROM contact";
                $querycon = mysqli_query($conn,$sqlcon);
                $resultcon = mysqli_fetch_assoc($querycon);
            ?>
            <div class="col-lg-8 col-12 d-flex flex-wrap">
                <p class="d-flex me-4 mb-0">
                    <i class="bi-geo-alt me-2"></i>
                    ศูนย์นวัตกรรมและเทคโนโลยีการศึกษา
                </p>

                <p class="d-flex me-4 mb-0">
                    <i class="bi-envelope me-2"></i>
                    <a href="patchare.sr@rmuti.ac.th">
                        <?php echo $resultcon['contact_email']; ?>
                    </a>
                </p>

                <p class="d-flex mb-0">
                    <i class="bi bi-telephone me-2"></i>
                    โทร <?php echo $resultcon['contact_tel']; ?>
                </p>
                    
            </div>
        </div>
    </div>
</header>
    
<nav class="navbar navbar-expand-lg shadow-lg"> <!-- แถบเมนู -->
    <div class="container">
        <a href="index.php">
            <img src="../assets/img/logo.png" height="90px" alt=""> 
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                    
                <li class="nav-item" >
                    <a class="nav-link <?php echo ($menu=='index.php'?'active':'') ?>" href="index.php">หน้าแรก</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link click-scroll dropdown-toggle <?php echo ($menu=='examSchedule.php'|| $menu=='mission.php'|| $menu=='people.php'?'active':'') ?>" href="#"
                        id="navbarLightDropdownMenuLink" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">เกี่ยวกับเรา</a>

                    <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarLightDropdownMenuLink">
                        <li><a class="dropdown-item" href="examSchedule.php">ประวัติ</a></li>
                        <li><a class="dropdown-item" href="mission.php">พันธกิจ/ภารกิจหลัก</a></li>
                        <li><a class="dropdown-item" href="people.php">โครงสร้างบุคลากร</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link click-scroll dropdown-toggle <?php echo ($menu=='news.php'|| $menu=='newsactivity.php'|| $menu=='newsdetail.php'|| $menu=='newsall.php'?' active':'') ?>" href="#"
                        id="navbarLightDropdownMenuLink" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">ข่าวประชาสัมพันธ์</a>

                    <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarLightDropdownMenuLink">
                        <li><a class="dropdown-item" href="news.php?page=1">ข่าวประชาสัมพันธ์ทุน</a></li>
                        <li><a class="dropdown-item" href="newsactivity.php?page=1">ข่าวกิจกรรม</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link click-scroll dropdown-toggle <?php echo ($menu=='DBmou.php'|| $menu=='DBactivity.php'|| $menu=='moAgency.php'|| $menu=='moDetails.php'|| $menu=='actAgency.php'|| $menu=='actDetails.php'|| $menu=='mouDB.php'|| $menu=='activityDB.php'|| $menu=='mouSystem.php'|| $menu=='mouEdit.php'|| $menu=='activitySystem.php'|| $menu=='activityEdit.php'?' active':'') ?>" href="#"
                        id="navbarLightDropdownMenuLink" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">การร่วมมือทางวิชาการ</a>

                    <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarLightDropdownMenuLink">
                        <li><a class="dropdown-item" href="DBmou.php">ฐานข้อมูลการทำความร่วมมือ</a></li>
                        <li><a class="dropdown-item" href="DBactivity.php">กิจกรรมการร่วมมือทางวิชาการ</a></li>
                        <li><a class="dropdown-item" href="mouDB.php">ระบบบันทึกข้อมูลการลงนาม(MOI/MOU/MOA)</a></li>
                        <li><a class="dropdown-item" href="activityDB.php">ระบบบันทึกกิจกรรมภายใต้การลงนาม(MOI/MOU/MOA)</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo ($menu=='service.php'|| $menu=='SVdetail.php'?'active':'') ?>" href="service.php">บริการ</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo ($menu=='download.php'?'active':'') ?>" href="download.php">ดาวน์โหลด</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo ($menu=='qa.php'?'active':'') ?>" href="qa.php">ถาม-ตอบ</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo ($menu=='contact.php'?'active':'') ?>" href="contact.php">ติดต่อ</a>
                </li>

                <li class="nav-item dropdown ms-3">
                    <a class="nav-profile click-scroll dropdown-toggle <?php echo ($menu=='peofileEdit.php'?'active':'') ?>" href="#"
                        id="navbarLightDropdownMenuLink" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <img src="../pic/logo/<?php echo $_SESSION['ag_img']; ?>" class="rounded-circle">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-light profile" aria-labelledby="navbarLightDropdownMenuLink">
                        <li class="dropdown-top">
                            <h6><?php echo $_SESSION['name'] .'   '. $_SESSION['lastname'] ?></h6>
                            <span><?php echo $_SESSION['campus2']; ?> <br><?php echo $_SESSION['agency_name']; ?></span>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="profileEdit.php?user_id=<?php echo $_SESSION['login'] ?>">
                                <i class="bi bi-person me-2"></i>
                                โปรไฟล์
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="../logout.php">
                                <i class="bi bi-box-arrow-right me-2"></i>
                                ออกจากระบบ
                            </a>
                        </li>
                    </ul>
                </li>   
            </ul>     
        </div>  
    </div>
</nav>