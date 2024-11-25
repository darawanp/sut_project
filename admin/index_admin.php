<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>ผู้ดูแลระบบ | เลือกวัน เวลา คุมสอบ</title>
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
  <?php include("menu_admin.php") ?>
  <main id="main" class="main">
    <section class="section dashboard">
      <div class="d-flex mb-4 align-items-center">
        <div class="pagetitle">
          <h2>Administrator | ผู้ดูแลระบบ</h2>
        </div>
        <button class="btn btn-success btn-round ms-auto" type="button" data-bs-toggle="modal"
          data-bs-target="#previewModal"><i class="bi bi-bar-chart-fill me-2"></i>ออกรายงาน</button>
        <!--<a href="textwrapping.php" class="btn btn-warning">ดูตัวอย่างโค้ด</a>-->
      </div>

      <div class="modal fade" id="previewModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
          <div class="modal-content" style="background: rgba(255, 255, 255, .9);">
            <div class="modal-header border-0">
              <button type="button" class="btn bg-danger btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex align-items-center justify-content-center">
              <div class="col-lg-8">
                <div class="card">
                  <div class="card-site text-center">
                    <h5 class="card-title">ดูรายงาน</h5>
                  </div>

                  <div class="card-body">
                    <div class="detail">
                      <form action="report.php" method="POST">
                        <div class="mb-3">
                          <div class="d-flex">
                            <label class="form-label col-lg-4">หัวข้อที่ต้องการออกรายงาน</label>
                            <input type="text" class="form-control" name="table_name" value="รายชื่อคนคุมสอบ">
                          </div>
                        </div>

                        <div class="mb-3">
                          <div class="d-flex">
                            <label class="form-label col-lg-4">กรุณาเลือกฝ่ายงาน</label>
                            <select class="form-select" name="ag_id">
                              <option selected>เลือกฝ่าย</option>
                              <option value="all">ทั้งหมด</option>
                              <option value="korat">สื่อคอม</option>
                              <option value="khonkean">เทคนิค</option>
                              <option value="sakonnakhon">สำนักพิมพ์</option>
                              <option value="surin">วิจัย</option>
                              <?php
                              $statusList = array("1"=>"มทร.อีสาน", "2"=> "มทร.ขอนแก่น", "3"=>"มทร.สกลนคร", "4"=>"มทร.สุรินทร์");
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

                        <div class="mb-4">
                          <div class="d-flex">
                            <label class="form-label col-lg-4">เลือกรายชื่อ</label>
                            <select class="form-select" name="Mo_type">
                              <option selected>เลือกรายชื่อคนที่คุมสอบ</option>
                              <option value="all">ทั้งหมด</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                            </select>
                          </div>
                        </div>
                        <hr>  
                        <div class="row mb-3">
                          <label class="form-label">วันที่สอบ </label>
                          <div class="col-lg-6">
                            <input type="date" class="form-control" name="dateInsert">
                          </div>
                          <div class="col-lg-6">
                            <input type="date" class="form-control" name="dateDelect">
                          </div>
                        </div>

                        <div class="text-center">
                          <button type="submit" class="btn btn-success">ออกรายงาน</button>
                        </div>
                        

                      </form>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-4">
          <div class="card info-card customers-card">
            <div class="card-body">
              <h5 class="card-title">วันนี้</h5>
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
              <h5 class="card-title">จำนวนฝ่ายที่เลือก <span>| วันนี้</span></h5>
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
              <h5 class="card-title">จำนวนคนที่เพิ่ม <span>| วันนี้</span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-stars"></i>
                </div>
                <?php
                $sql2 = "SELECT * FROM activity WHERE dates_tr='" . $date . "'";
                $query2 = mysqli_query($conn, $sql2);
                  echo '<div class="ps-3">
                      <h6>0</h6>
                    </div>';
                ?>
              </div>
            </div>
          </div>
        </div> 

        <div class="col-lg-6">
          <div class="card">

            <div class="card-body">
              <h5 class="card-title">สถิติการคุมสอบของแต่ละคน <span>/ทั้งหมด</span></h5>

              <div id="barChart"></div>
              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  new ApexCharts(document.querySelector("#barChart"), {
                    series: [{
                      data: [20, 10, 15, 5]
                    }],
                    chart: {
                      type: 'bar',
                      height: 800
                    },
                    plotOptions: {
                      bar: {
                        borderRadius: 4,
                        horizontal: true,
                      }
                    },
                    dataLabels: {
                      enabled: false
                    },
                    xaxis: {
                      categories: ['คนที่1', 'คนที่2', 'คนที่3', 'คนที่4', 'คนที่5', 'คนที่6', 'คนที่7', 'คนที่8',
                      'คนที่9', 'คนที่10', 'คนที่11', 'คนที่12', 'คนที่13', 'คนที่14', 'คนที่15', 'คนที่16','คนที่17',
                      'คนที่18', 'คนที่19', 'คนที่20', 'คนที่21', 'คนที่22', 'คนที่23', 'คนที่24', 'คนที่25', 'คนที่26',
                      'คนที่27', 'คนที่28', 'คนที่29', 'คนที่30', 'คนที่31', 'คนที่32', 'คนที่34', 'คนที่35', 'คนที่36',
                      ]
                    }

                  }).render();
                });
              </script>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card">

            <div class="card-body">
              <h5 class="card-title">สถิติการคุมสอบของแต่ละฝ่าย <span>/ทั้งหมด</span></h5>

              <div id="pieChart"></div>

              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  new ApexCharts(document.querySelector("#pieChart"), {
                    series: [55, 35, 20, 13],
                    chart: {
                      height: 350,
                      type: 'pie',
                      toolbar: {
                        show: true
                      }
                    },
                    labels: ['ฝ่ายบริหารงานทั่วไป', 'ฝ่ายวิจัยและพัฒนาสื่อการศึกษา', 
                    'ฝ่ายผลิตสื่อคอมพิวเตอร์', 'ฝ่ายผลิตสื่อโสตทัศน์', 'ฝ่ายเทคนิควิศวกรรม', 'สำนักพิมพ์', 'ฝ่ายพัฒนานวัตกรรม']
                  }).render();
                });
              </script>
            </div>
          </div>
        </div> <br>

        



  <?php
  include("footer_admin.php");
  ?>
</body>