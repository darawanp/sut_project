<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>บันทึกการลงนามวันนี้ - Admin Management</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/RMUTI.png" rel="icon">
  <link href="../assets/img/RMUTI2.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" crossorigin rel="preconnect">
  <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">

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
  <?php include("menu-admin.php") ?>
  <main id="main" class="main">
    <section class="section dashboard">
      <div class="d-flex mb-4 align-items-center">
        <div id="pagetitle">
          <h2>หน้าแรก</h2>
          <nav>
            <ol class="breadcrumb mt-3">
              <li class="breadcrumb-item"><a href="index-admin.php">หน้าแรก</a></li>
              <li class="breadcrumb-item"><a href="index-mou.php">ข้อมูลบันทึกการลงนามที่เพิ่มวันนี้</a></li>
            </ol>
          </nav>
        </div>
        <button class="btn btn-success btn-round ms-auto"><i class="bi bi-bar-chart-fill me-2"></i>ดูรายงาน</button>
        <button class="btn btn-success btn-round ms-2"><i class="bx bxs-report me-2"></i>ออกรายงาน</button>
      </div>
      <div class="row">
        <div class="col-lg-4">
          <div class="card info-card customers-card">
            <div class="card-body">
              <h5 class="card-title">Today</h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-calendar4"></i>
                </div>
                <div class="ps-3">
                  <?php $date = date("Y-m-d") ?>
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
                  <h6><?php echo DateThai($date) ?></h6>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card info-card customers-card">
            <div class="card-body">
              <h5 class="card-title">จำนวนบันทึกการลงนามที่เพิ่ม <span>| วันนี้</span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-book"></i>
                </div>
                <?php
                $sql = "SELECT * FROM mou WHERE dates_tr='" . $date . "'";
                $query = mysqli_query($conn, $sql);
                $numrow = mysqli_num_rows($query);

                if ($numrow > 0) {
                  echo '<div class="ps-3">
                      <h6>' . $numrow . '</h6>
                    </div>';
                } else {
                  echo '<div class="ps-3">
                      <h6>0</h6>
                    </div>';
                }
                ?>

              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card info-card customers-card">
            <div class="card-body">
              <h5 class="card-title">จำนวนกิจกรรมที่เพิ่ม <span>| วันนี้</span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-stars"></i>
                </div>
                <?php
                $sql2 = "SELECT * FROM activity WHERE dates_tr='" . $date . "'";
                $query2 = mysqli_query($conn, $sql2);
                $numrow2 = mysqli_num_rows($query2);

                if ($numrow2 > 0) {
                  echo '<div class="ps-3">
                      <h6>' . $numrow . '</h6>
                    </div>';
                } else {
                  echo '<div class="ps-3">
                      <h6>0</h6>
                    </div>';
                }
                ?>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-12">
          <div class="card info-card customers-card">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <h5 class="card-title">บันทึกการลงนามที่เพิ่ม <span>| วันนี้</span></h5>
                <a href="newsCreate.php" class="ms-auto">
                  <button class="btn btn-primary btn-round me-2">
                    <i class="bi bi-clipboard2-plus-fill me-1"></i>
                    เพิ่มบันทึกการลงนาม
                  </button>
                </a>
              </div>
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">ลำดับ</th>
                    <th>ชื่อบันทึกความร่วมมือ</th>
                    <th>ประเภท</th>
                    <th>หน่วยงานที่ดำเนินการ</th>
                    <th class="text-center"><i class="bi bi-gear-fill"></i></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if ($numrow > 0) {
                    while ($row = mysqli_fetch_assoc($query)) {
                      echo '<tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-center">
                      <a href="" class="btn btn-primary"><i class="bi bi-eye-fill"></i></a>
                    </td>
                  </tr>';
                    }
                  } else {
                    echo '<tr><td colspan="6" align="center">ยังไม่มีข้อมูล</td></tr>';
                  }
                  ?>

                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>
    </section>
  </main>




  <?php
  include("footer-admin.php");
  ?>
</body>