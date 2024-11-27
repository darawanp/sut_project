<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>บันทึกข้อมูลการคุมสอบ</title>
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
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="../assets/css/style.css" rel="stylesheet">

    <!-- SummerNote -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <style>
        /* Style the calendar view */
        #calendar {
            max-width: 100%;
            margin: 0 auto;
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Style the buttons */
        #toggleViewBtn {
            font-size: 16px;
            padding: 8px 16px;
            border-radius: 4px;
            background-color: #6c757d;
            /* Grey color */
            color: white;
            border: none;
            transition: background-color 0.3s ease;
        }

        #toggleViewBtn:hover {
            background-color: #5a6268;
            /* Darker grey for hover */
        }


        /* FullCalendar customizations */
        .fc-toolbar {
            background-color: #4e73df;
            color: white;
            border-radius: 6px;
            padding: 10px;
        }

        .fc-toolbar .fc-button {
            background-color: #007bff;
            border: none;
            color: white;
        }

        .fc-toolbar .fc-button:hover {
            background-color: #0056b3;
        }

        .fc-daygrid-day-number {
            font-weight: bold;
        }

        .fc-daygrid-day-top {
            background-color: #f1f1f1;
            border-radius: 6px;
        }

        .fc-daygrid-event {
            background-color: #28a745;
            color: white;
            border-radius: 4px;
            font-size: 12px;
            padding: 4px 8px;
        }

        .fc-daygrid-event:hover {
            background-color: #218838;
        }

        .fc-event-time {
            display: none !important;
        }
    </style>
</head>

<body>
    <?php include("menu_admin.php") ?>
    <main id="main" class="main">

        <div class="pagetitle text-center">
            <h2>บันทึกข้อมูลการคุมสอบ</h2>
            <nav class="d-flex justify-content-center">
                <ol class="breadcrumb mt-3">
                    <li class="breadcrumb-item"><a href="index_admin.php">หน้าแรก</a></li>
                    <li class="breadcrumb-item active">บันทึกข้อมูลการคุมสอบ</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="col-12">
                <div class="card">
                    <div class="card-site d-flex align-items-center">
                        <h5 class="card-title me-3">ข้อมูลการคุมสอบ</h5>
                        <button style="display: none;" id="toggleViewBtn" class="btn btn-secondary ms-auto me-2">
                            <i class="bi bi-calendar-fill"></i> สลับมุมมองเป็นปฏิทิน
                        </button>
                        <a href="examMidterm.php">
                            <button class="btn btn-primary btn-round me-2">
                                <i class="card-icon bi bi-person-plus-fill me-1"></i>
                                สอบกลางภาค
                            </button>
                        </a>
                        <a href="examFinal.php">
                            <button class="btn btn-primary btn-round me-2">
                                <i class="card-icon bi bi-person-plus-fill me-1"></i>
                                สอบประจำภาค
                            </button>
                        </a>
                    </div>

                    <div class="card-body">
                        <div id="tableView" class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">ลำดับ</th>
                                        <th class="text-center">ประเภทการสอบ</th>
                                        <th class="text-center">วันที่สอบ</th>
                                        <th class="text-center">เวลาเริ่มสอบ</th>
                                        <th class="text-center">เวลาสิ้นสุด</th>
                                        <th class="text-center">จำนวนคนคุมสอบ</th>
                                        <th class="text-center">วันที่แก้ไข</th>
                                        <th class="text-center">จัดการ</th> <!-- คอลัมน์จัดการ -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // ดึงข้อมูลจากตาราง exam_schedule และ exam_types
                                    $sql = "SELECT es.*, et.exam_types_name 
                                            FROM exam_schedule es
                                            LEFT JOIN exam_types et ON es.exam_type_id = et.exam_type_id
                                            ORDER BY es.updated_at ASC";
                                    $result = mysqli_query($conn, $sql);
                                    $numrow = mysqli_num_rows($result);

                                    // ฟังก์ชันสำหรับแปลงวันที่เป็นรูปแบบไทย
                                    function formatDateThai($date)
                                    {
                                        $thai_months = [
                                            1 => 'มกราคม',
                                            2 => 'กุมภาพันธ์',
                                            3 => 'มีนาคม',
                                            4 => 'เมษายน',
                                            5 => 'พฤษภาคม',
                                            6 => 'มิถุนายน',
                                            7 => 'กรกฎาคม',
                                            8 => 'สิงหาคม',
                                            9 => 'กันยายน',
                                            10 => 'ตุลาคม',
                                            11 => 'พฤศจิกายน',
                                            12 => 'ธันวาคม'
                                        ];
                                        // Convert to timestamp
                                        $timestamp = strtotime($date);
                                        // Format date in Thai format
                                        $day = date('d', $timestamp);
                                        $month = $thai_months[date('n', $timestamp)]; // Get the Thai month name
                                        $year = date('Y', $timestamp) + 543; // Convert to Buddhist year (add 543)
                                        return "$day $month $year";
                                    }
                                    function formatDateThaiTime($date)
                                    {
                                        $thai_months = [
                                            1 => 'มกราคม',
                                            2 => 'กุมภาพันธ์',
                                            3 => 'มีนาคม',
                                            4 => 'เมษายน',
                                            5 => 'พฤษภาคม',
                                            6 => 'มิถุนายน',
                                            7 => 'กรกฎาคม',
                                            8 => 'สิงหาคม',
                                            9 => 'กันยายน',
                                            10 => 'ตุลาคม',
                                            11 => 'พฤศจิกายน',
                                            12 => 'ธันวาคม'
                                        ];
                                        // Convert to timestamp
                                        $timestamp = strtotime($date);
                                        // Format date in Thai format
                                        $day = date('d', $timestamp);
                                        $month = $thai_months[date('n', $timestamp)]; // Get the Thai month name
                                        $year = date('Y', $timestamp) + 543; // Convert to Buddhist year (add 543)
                                        $time = date('H:i', $timestamp); // Extract time in hours:minutes format
                                        return "$day $month $year เวลา $time น.";
                                    }


                                    if ($numrow > 0) {
                                        $i = 1;
                                        while ($row = mysqli_fetch_assoc($result)) { ?>
                                            <tr>
                                                <td class="text-center"><?php echo $i++; ?></td>
                                                <td class="text-center"><?php echo $row['exam_types_name']; ?></td>
                                                <td class="text-center"><?php echo formatDateThai($row['exam_date']); ?></td>
                                                <td class="text-center"><?php echo date('H:i', strtotime($row['exam_start_times'])) . ' น.'; ?></td>
                                                <td class="text-center"><?php echo date('H:i', strtotime($row['exam_end_times'])) . ' น.'; ?></td>
                                                <td class="text-center"><?php echo $row['num_proctors']; ?></td>
                                                <td class="text-center"><?php echo formatDateThaiTime($row['updated_at']); ?></td>
                                                <td class="text-center">
                                                    <?php
                                                    // Determine the edit page based on exam type
                                                    $editPage = ($row['exam_types_name'] == 'สอบกลางภาค') ? 'examEditMidterm.php' : 'examEditFinal.php';
                                                    ?>
                                                    <!-- Edit Button -->
                                                    <a href="<?php echo $editPage; ?>?id=<?php echo $row['exam_id']; ?>" class="btn btn-warning btn-sm">
                                                        <i class="bi bi-pencil-fill"></i> แก้ไข
                                                    </a>
                                                    <!-- Delete Button -->
                                                    <a href="javascript:void(0);" class="btn btn-danger btn-sm" onclick="confirmDelete('examDelete.php?id=<?php echo $row['exam_id']; ?>')">
                                                        <i class="bi bi-trash-fill"></i> ลบ
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php }
                                    } else { ?>
                                        <tr>
                                            <td colspan="8" class="text-center">ไม่มีข้อมูลการคุมสอบ</td>
                                        </tr>
                                    <?php }
                                    ?>
                                </tbody>

                            </table>
                        </div>
                        <!-- มุมมองปฏิทิน -->
                        <div id="calendarView" style="display: none;">
                            <div id="calendar"></div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>
    <?php include("footer_admin.php") ?>

    <!-- เพิ่ม link สำหรับ SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

    <script>
        // ฟังก์ชันยืนยันการลบ
        function confirmDelete(url) {
            Swal.fire({
                title: 'คุณต้องการลบข้อมูลนี้ใช่ไหม?',
                text: "ข้อมูลจะถูกลบถาวร!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    // ถ้าผู้ใช้กดตกลง ให้ทำการลบข้อมูลโดยการส่งคำขอไปยัง URL ที่ระบุ
                    window.location.href = url;
                }
            });
        }

        // ตรวจสอบค่าจาก URL หากมีการแสดงผล SweetAlert
        <?php if (isset($_GET['status'])): ?>
            const status = '<?php echo $_GET['status']; ?>';
            if (status === 'error') {
                Swal.fire({
                    title: 'สำเร็จ!',
                    text: 'การดำเนินการสำเร็จ',
                    icon: 'error',
                    timer: 1000, // Disappear after 1 seconds
                    showConfirmButton: false // Hide the confirm button
                });
            } else if (status === 'error') {
                Swal.fire({
                    title: 'เกิดข้อผิดพลาด!',
                    text: 'การดำเนินการไม่สำเร็จ',
                    icon: 'error',
                    timer: 1000, // Disappear after 1 seconds
                    showConfirmButton: false // Hide the confirm button
                });
            }
        <?php endif; ?>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleViewBtn = document.getElementById('toggleViewBtn');
            const tableView = document.getElementById('tableView');
            const calendarView = document.getElementById('calendarView');
            const calendarEl = document.getElementById('calendar');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'th',
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                height: 600,
                aspectRatio: 1.5,
                events: [
                    <?php
                    mysqli_data_seek($result, 0);
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Format the start and end times without seconds and add "น."
                        $start_time = date('H:i', strtotime($row['exam_start_times'])) . ' น.';
                        $end_time = date('H:i', strtotime($row['exam_end_times'])) . ' น.';
                        $num_proctors = $row['num_proctors']; // Assuming this is the column storing the number of proctors
                        echo "{
                            title: 'เริ่ม: {$start_time} ถึง {$end_time}',
                            start: '{$row['exam_date']}T{$row['exam_start_times']}',
                            end: '{$row['exam_date']}T{$row['exam_end_times']}',
                            description: '{$row['exam_types_name']} - วันที่: " . formatDateThai($row['exam_date']) . " เวลา {$start_time} ถึง {$end_time} จำนวนคนคุมสอบ: {$num_proctors} คน'
                        },";
                    }
                    ?>
                ],
                eventColor: '#007bff',
                eventTextColor: '#ffffff',
                eventBorderColor: '#0056b3',
                eventClassNames: ['event-class'],
                droppable: true,
                editable: true,
                selectable: true,
                eventClick: function(info) {
                    // Format time without seconds and add "น."
                    const startTime = info.event.start.toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit'
                    }) + ' น.';
                    const endTime = info.event.end.toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit'
                    }) + ' น.';

                    Swal.fire({
                        title: 'ประเภทการสอบ: ' + info.event.extendedProps.description.split(' - ')[0],
                        text: `รายละเอียด: ${info.event.extendedProps.description}`,
                        icon: 'info',
                        confirmButtonText: 'ปิด'
                    });
                },
                eventMouseEnter: function(info) {
                    const description = info.event.extendedProps.description;
                    const startTime = info.event.start.toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit'
                    }) + ' น.';
                    const endTime = info.event.end.toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit'
                    }) + ' น.';

                    $(info.el).tooltip({
                        title: `${description}\nเวลา: ${startTime} - ${endTime}`,
                        placement: 'top',
                        trigger: 'hover',
                    }).tooltip('show');
                }
            });

            toggleViewBtn.addEventListener('click', function() {
                if (calendarView.style.display === 'none') {
                    calendarView.style.display = 'block';
                    tableView.style.display = 'none';
                    calendar.render();
                    toggleViewBtn.innerHTML = '<i class="bi bi-table"></i> สลับมุมมองเป็นตาราง';
                } else {
                    tableView.style.display = 'block';
                    calendarView.style.display = 'none';
                    toggleViewBtn.innerHTML = '<i class="bi bi-calendar-fill"></i> สลับมุมมองเป็นปฏิทิน';
                }
            });
        });
    </script>

</body>

</html>