<?php require_once '../database/connect.php';
session_start();
$menu=basename($_SERVER['PHP_SELF']);
?>
<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="index_admin.php" class="logo d-flex align-items-center">
            <img src="../assets/img/logo.png" alt="">
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="" data-bs-toggle="dropdown">
                    <img src="../pic/logo/<?php echo $_SESSION['ag_img']; ?>"  class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $_SESSION['name'] .'   '. $_SESSION['lastname'] ?></span>
                </a>
                <!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6><?php echo $_SESSION['name'] .'   '. $_SESSION['lastname'] ?></h6>
                        <span><?php echo $_SESSION['campus']; ?></span>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="users_profile.php?user_id=<?php echo $_SESSION['login'] ?>">
                            <i class="bi bi-person"></i>
                            <span>โปรไฟล์</span>
                        </a>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="../logout.php">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>ออกจากระบบ</span>
                        </a>
                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->
        </ul>
    </nav><!-- End Icons Navigation -->
</header><!-- End Header -->

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link collapsed <?php echo ($menu=='index_admin.php'?'nav-link active':'') ?>" href="index_admin.php">
                <i class="bi bi-house-fill"></i>
                <span>หน้าแรก</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed <?php echo ($menu=='examSchedule.php'|| $menu=='mission.php'|| $menu=='M_mission.php'|| $menu=='people.php'|| $menu=='peopleCreate.php'|| $menu=='peopleEdit.php'?'active nav-link':'') ?>" data-bs-target="#about-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-info-circle-fill"></i><span>กำหนดวันคุมสอบ</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="about-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="examSchedule.php">
                        <i class="bi bi-circle-fill"></i><span>บันทึกข้อมูลการสอบ</span>
                    </a>
                </li>
                <li>
                    <a href="mission.php">
                        <i class="bi bi-circle-fill"></i><span>รายชื่อกรรมการคุมสอบ</span>
                    </a>
                </li>
                <li>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed <?php echo ($menu=='news.php'|| $menu=='news_act.php'|| $menu=='newsCreate.php'|| $menu=='newsEdit.php'|| $menu=='viewer_news.php'?'active nav-link':'') ?>" data-bs-target="#form-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-info-circle-fill"></i><span>สถิติการคุมสอบรายบุคคล</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="form-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="news.php">
                        <i class="bi bi-circle-fill"></i><span>บันทึกข้อมูล</span>
                    </a>
                </li>
                <li>
                    <a href="news_act.php">
                        <i class="bi bi-circle-fill"></i><span>ดูตารางข้อมูล</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-heading"><hr></li>

        <li class="nav-item">
            <a class="nav-link collapsed <?php echo ($menu=='profile.php' || $menu=='userCreate.php' || $menu=='profileEdit.php'?'active nav-link':'') ?>" href="profile.php">
                <i class="bi bi-person-circle"></i>
                <span>บริหารจัดการ User</span>
            </a>
        </li>
    </ul>
</aside><!-- End Sidebar-->

