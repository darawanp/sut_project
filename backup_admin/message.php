<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>ข้อความ - Admin Management</title>
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
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
</head>

<body>
    <?php include("menu_admin.php") ?>
    <main id="main" class="main">

        <div class="pagetitle text-center">
            <h2>ข้อความเข้า</h2>
            <nav class="d-flex justify-content-center">
                <ol class="breadcrumb mt-3">
                    <li class="breadcrumb-item"><a href="index_admin.php">หน้าแรก</a></li>
                    <li class="breadcrumb-item"><a href="message.php">ข้อความเข้า</a></li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="col-12">
                <div class="card">
                    <div class="card-site d-flex align-items-center">
                        <h5 class="card-title">ข้อความทั้งหมด</h5>
                    </div>

                    <div class="card-body">
                        <?php
                            $sqlSelect = "SELECT * FROM message";
                            $result = mysqli_query($conn, $sqlSelect);
                            $numrow = mysqli_num_rows($result);
                        ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">ลำดับ</th>
                                        <th>เรื่อง</th>
                                        <th>ผู้ถาม</th>
                                        <th class="text-center"><i class="bi bi-gear-fill"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result && mysqli_num_rows($result) > 0) {
                                        $i=1;
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<tr>
                                                <td class="text-center">'.$i++.'</td>
                                                <td hidden>'.$row['MS_no'].'</td>
                                                <td>'.$row['question'].'</td>
                                                <td>'.$row['qa_username'].'</td>
                                                <td class="text-center">
                                                    <a href="qaInsertMS.php?MS_no='.$row['MS_no'].'" class="btn btn-primary"><i class="bi bi-plus-lg"></i></a>
                                                    <a href="messageEdit.php?MS_no='.$row['MS_no'].'" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
                                                    <a href="messageDelete.php?MS_no='.$row['MS_no'].'" class="btn btn-danger" onclick="return confirm(\'คุณแน่ใจหรือว่าต้องการลบข้อมูลนี้?\')"><i class="bi bi-trash3-fill"></i></a>
                                                </td>  
                                            </tr>';
                                        }
                                    } else {
                                        // กรณีไม่พบข้อมูล
                                        echo '<tr><td colspan="6" align="center">ไม่พบข้อมูล</td></tr>';
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
        include("footer_admin.php")
    ?>
</body>