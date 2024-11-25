<?php require_once '../database/connect.php';
require('../fpdf/fpdf.php');

function DateThai($strDate)
{ //ฟังก์ชันเปลี่ยนวันที่เป็นวันที่ไทย
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strMonthCut = array("", "มกราคม.", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}


// สร้าง PDF
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->SetMargins(15, 47, 15); // ปรับระยะห่าง ซ้าย-กลาง-ขวา
$pdf->AddPage();
$pdf->AddFont('Sarabun-Bold', '', 'Sarabun-Bold.php');
$pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');

// ดึงข้อมูลจากฐานข้อมูลมาแสดงข้อความ
$statusList = array("1" => "ศูนย์กลางนครราชสีมา", "2" => "วิทยาเขตขอนแก่น", "3" => "วิทยาเขตสกลนคร", "4" => "วิทยาเขตสุรินทร์");
$sql = "SELECT * FROM agency_university WHERE ag_id='" . $_POST['ag_id'] . "'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// หัวข้อเอกสาร
$pdf->SetFont('Sarabun-Bold', '', 16);
$pdf->Image('../pic/logo/RMUTI_KORAT.png', 92, 10, 25, 35, '');
$pdf->Cell(0, 10, iconv('UTF-8', 'TIS-620', 'รายงานข้อมูล'), 0, 1, 'C');


if ($_POST['table_name'] == "บันทึกการลงนาม") { //ถ้าเลือกหัวข้อเป็น mou ตรวจสอบค่าที่รับมาต่อไปนี้
    //ตรวจสอบการเลือกหน่วยงาน
    if ($_POST['ag_id'] != "all" && $_POST['ag_id'] != "korat" && $_POST['ag_id'] != "khonkean" && $_POST['ag_id'] != "sakonnakhon" && $_POST['ag_id'] != "surin") { //มีการเลือกหน่วยงาน และหน่วยงาน 1 (มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน)
        //ตรวจสอบการเลือกประเภทของบันทึกความร่วมมือ
        if ($_POST['Mo_type'] == "all") {
            $pdf->SetFont('THSarabunNew', '', 16);
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'เรื่อง บันทึกการลงนามความร่วมมือทุกประเภทความร่วมมือ'), 0, 1, 'C');
            $pdf->Ln(1); // เพิ่มระยะห่าง
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . $row['agencyname_thai'] . ''), 0, 1, 'C');
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน ' . $statusList[$row['campus']] . ''), 0, 1, 'C');
            $pdf->Ln(8); // เพิ่มระยะห่าง

            if ($_POST['dateInsert'] && $_POST['dateDelect'] && $_POST['dateStart'] && $_POST['dateEnd']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM mou WHERE ag_id='" . $_POST['ag_id'] . "' AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired= '" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ที่มีการลงนามในวันที่'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . DateThai($_POST['dateStart']) . ' หรือหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดย   MOI หมายถึง บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOU หมายถึง บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOA หมายถึง บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement)'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateInsert'] && $_POST['dateDelect']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM mou WHERE ag_id='" . $_POST['ag_id'] . "' AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' ORDER BY dates_tr ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ซึ่งมีข้อมูลทั้งหมด'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดย   MOI หมายถึง บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOU หมายถึง บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOA หมายถึง บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement)'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart'] && $_POST['dateEnd']) {
                $sql = "SELECT * FROM mou WHERE ag_id='" . $_POST['ag_id'] . "' AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired='" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' หรือวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดย   MOI หมายถึง บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOU หมายถึง บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOA หมายถึง บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement)'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart']) {
                $sql = "SELECT * FROM mou WHERE ag_id='" . $_POST['ag_id'] . "' AND dateStart='" . $_POST['dateStart'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดย   MOI หมายถึง บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOU หมายถึง บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOA หมายถึง บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement)'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateEnd']) {
                $sql = "SELECT * FROM mou WHERE ag_id='" . $_POST['ag_id'] . "' AND dateExpired='" . $_POST['dateEnd'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดย   MOI หมายถึง บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOU หมายถึง บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOA หมายถึง บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement)'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } else {
                $sql = "SELECT * FROM mou WHERE ag_id='" . $_POST['ag_id'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดยรายงานข้อมูลนี้เป็นข้อมูลการทำความร่วมมือทั้งหมด ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตาราง'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดย   MOI หมายถึง บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOU หมายถึง บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOA หมายถึง บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement)'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง
            }

        } elseif ($_POST['Mo_type'] == "1") {
            $pdf->SetFont('THSarabunNew', '', 16);
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'เรื่อง บันทึกการลงนามความร่วมมือ ประเภทบันทึกแสดงเจตจํานงทางวิชาการ (MOI)'), 0, 1, 'C');
            $pdf->Ln(1); // เพิ่มระยะห่าง
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . $row['agencyname_thai'] . ''), 0, 1, 'C');
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน ' . $statusList[$row['campus']] . ''), 0, 1, 'C');
            $pdf->Ln(8); // เพิ่มระยะห่าง

            if ($_POST['dateInsert'] && $_POST['dateDelect'] && $_POST['dateStart'] && $_POST['dateEnd']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM mou WHERE ag_id='" . $_POST['ag_id'] . "' AND Mo_type=1 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired= '" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ที่มีการลงนามในวันที่'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . DateThai($_POST['dateStart']) . ' หรือหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateInsert'] && $_POST['dateDelect']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM mou WHERE ag_id='" . $_POST['ag_id'] . "' AND Mo_type='1' AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' ORDER BY dates_tr ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ซึ่งมีข้อมูลทั้งหมด'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart'] && $_POST['dateEnd']) {
                $sql = "SELECT * FROM mou WHERE ag_id='" . $_POST['ag_id'] . "' AND Mo_type=1 AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired='" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' หรือวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart']) {
                $sql = "SELECT * FROM mou WHERE ag_id='" . $_POST['ag_id'] . "' AND Mo_type=1 AND dateStart='" . $_POST['dateStart'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateEnd']) {
                $sql = "SELECT * FROM mou WHERE ag_id='" . $_POST['ag_id'] . "' AND Mo_type=1 AND dateExpired='" . $_POST['dateEnd'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } else {
                $sql = "SELECT * FROM mou WHERE ag_id='" . $_POST['ag_id'] . "' AND Mo_type=1 ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดยรายงานข้อมูลนี้เป็นข้อมูลการทำความร่วมมือทั้งหมด ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตาราง'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง
            }

        } elseif ($_POST['Mo_type'] == "2") {
            $pdf->SetFont('THSarabunNew', '', 16);
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'เรื่อง บันทึกการลงนามความร่วมมือ ประเภทบันทึกความเข้าใจทางวิชาการ (MOU)'), 0, 1, 'C');
            $pdf->Ln(1); // เพิ่มระยะห่าง
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . $row['agencyname_thai'] . ''), 0, 1, 'C');
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน ' . $statusList[$row['campus']] . ''), 0, 1, 'C');
            $pdf->Ln(8); // เพิ่มระยะห่าง

            if ($_POST['dateInsert'] && $_POST['dateDelect'] && $_POST['dateStart'] && $_POST['dateEnd']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM mou WHERE ag_id='" . $_POST['ag_id'] . "' AND Mo_type=2 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired= '" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result1 = $stmt->get_result();
                $numrow = $result1->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ที่มีการลงนามในวันที่'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . DateThai($_POST['dateStart']) . ' หรือหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateInsert'] && $_POST['dateDelect']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM mou WHERE ag_id='" . $_POST['ag_id'] . "' AND Mo_type=2 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' ORDER BY dates_tr ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result1 = $stmt->get_result();
                $numrow = $result1->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ซึ่งมีข้อมูลทั้งหมด'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart'] && $_POST['dateEnd']) {
                $sql = "SELECT * FROM mou WHERE ag_id='" . $_POST['ag_id'] . "' AND Mo_type=2 AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired='" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result1 = $stmt->get_result();
                $numrow = $result1->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' หรือวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart']) {
                $sql = "SELECT * FROM mou WHERE ag_id='" . $_POST['ag_id'] . "' AND Mo_type=2 AND dateStart='" . $_POST['dateStart'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result1 = $stmt->get_result();
                $numrow = $result1->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateEnd']) {
                $sql = "SELECT * FROM mou WHERE ag_id='" . $_POST['ag_id'] . "' AND Mo_type=2 AND dateExpired='" . $_POST['dateEnd'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result1 = $stmt->get_result();
                $numrow = $result1->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } else {
                $sql = "SELECT * FROM mou WHERE ag_id='" . $_POST['ag_id'] . "' AND Mo_type=2 ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result1 = $stmt->get_result();
                $numrow = $result1->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดยรายงานข้อมูลนี้เป็นข้อมูลการทำความร่วมมือทั้งหมด ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตาราง'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง
            }

        } elseif ($_POST['Mo_type'] == "3") {
            $pdf->SetFont('THSarabunNew', '', 16);
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'เรื่อง บันทึกการลงนามความร่วมมือ ประเภทบันทึกข้อตกลงความร่วมมือทางวิชาการ (MOA)'), 0, 1, 'C');
            $pdf->Ln(1); // เพิ่มระยะห่าง
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . $row['agencyname_thai'] . ''), 0, 1, 'C');
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน ' . $statusList[$row['campus']] . ''), 0, 1, 'C');
            $pdf->Ln(8); // เพิ่มระยะห่าง

            if ($_POST['dateInsert'] && $_POST['dateDelect'] && $_POST['dateStart'] && $_POST['dateEnd']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM mou WHERE ag_id='" . $_POST['ag_id'] . "' AND Mo_type=3 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired= '" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result1 = $stmt->get_result();
                $numrow = $result1->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ที่มีการลงนามในวันที่'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . DateThai($_POST['dateStart']) . ' หรือหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateInsert'] && $_POST['dateDelect']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM mou WHERE ag_id='" . $_POST['ag_id'] . "' AND Mo_type=3 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' ORDER BY dates_tr ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result1 = $stmt->get_result();
                $numrow = $result1->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ซึ่งมีข้อมูลทั้งหมด'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart'] && $_POST['dateEnd']) {
                $sql = "SELECT * FROM mou WHERE ag_id='" . $_POST['ag_id'] . "' AND Mo_type=3 AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired='" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result1 = $stmt->get_result();
                $numrow = $result1->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' หรือวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart']) {
                $sql = "SELECT * FROM mou WHERE ag_id='" . $_POST['ag_id'] . "' AND Mo_type=3 AND dateStart='" . $_POST['dateStart'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result1 = $stmt->get_result();
                $numrow = $result1->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateEnd']) {
                $sql = "SELECT * FROM mou WHERE ag_id='" . $_POST['ag_id'] . "' AND Mo_type=3 AND dateExpired='" . $_POST['dateEnd'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result1 = $stmt->get_result();
                $numrow = $result1->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } else {
                $sql = "SELECT * FROM mou WHERE ag_id='" . $_POST['ag_id'] . "' AND Mo_type=3 ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result1 = $stmt->get_result();
                $numrow = $result1->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดยรายงานข้อมูลนี้เป็นข้อมูลการทำความร่วมมือทั้งหมด ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตาราง'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง
            }

        }
    } elseif ($_POST['ag_id'] == "all") { //ไม่มีการเลือกหน่วยงานไหนเลย
        //ตรวจสอบการเลือกประเภทของบันทึกความร่วมมือ
        if ($_POST['Mo_type'] == "all") {
            $pdf->SetFont('THSarabunNew', '', 16);
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'เรื่อง บันทึกการลงนามความร่วมมือทุกประเภทความร่วมมือ'), 0, 1, 'C');
            $pdf->Ln(1); // เพิ่มระยะห่าง
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ของหน่วยงานทั้งหมดในมหาวิทยาลัยเทคโนโลยีราชมงคลอีสานทุกวิทยาเขต'), 0, 1, 'C');
            $pdf->Ln(8); // เพิ่มระยะห่าง

            if ($_POST['dateInsert'] && $_POST['dateDelect'] && $_POST['dateStart'] && $_POST['dateEnd']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM mou WHERE dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired= '" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ที่มีการลงนามในวันที่'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . DateThai($_POST['dateStart']) . ' หรือหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดย   MOI หมายถึง บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOU หมายถึง บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOA หมายถึง บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement)'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateInsert'] && $_POST['dateDelect']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM mou WHERE dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' ORDER BY dates_tr ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ซึ่งมีข้อมูลทั้งหมด'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดย   MOI หมายถึง บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOU หมายถึง บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOA หมายถึง บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement)'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart'] && $_POST['dateEnd']) {
                $sql = "SELECT * FROM mou WHERE dateStart='" . $_POST['dateStart'] . "' OR dateExpired='" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' หรือวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดย   MOI หมายถึง บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOU หมายถึง บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOA หมายถึง บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement)'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart']) {
                $sql = "SELECT * FROM mou WHERE dateStart='" . $_POST['dateStart'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดย   MOI หมายถึง บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOU หมายถึง บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOA หมายถึง บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement)'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateEnd']) {
                $sql = "SELECT * FROM mou WHERE dateExpired='" . $_POST['dateEnd'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดย   MOI หมายถึง บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOU หมายถึง บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOA หมายถึง บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement)'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } else {
                $sql = "SELECT * FROM mou ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดยรายงานข้อมูลนี้เป็นข้อมูลการทำความร่วมมือทั้งหมด ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตาราง'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดย   MOI หมายถึง บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOU หมายถึง บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOA หมายถึง บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement)'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง
            }

        } elseif ($_POST['Mo_type'] == "1") {
            $pdf->SetFont('THSarabunNew', '', 16);
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'เรื่อง บันทึกการลงนามความร่วมมือ ประเภทบันทึกแสดงเจตจํานงทางวิชาการ (MOI)'), 0, 1, 'C');
            $pdf->Ln(1); // เพิ่มระยะห่าง
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ของหน่วยงานทั้งหมดในมหาวิทยาลัยเทคโนโลยีราชมงคลอีสานทุกวิทยาเขต'), 0, 1, 'C');
            $pdf->Ln(8); // เพิ่มระยะห่าง

            if ($_POST['dateInsert'] && $_POST['dateDelect'] && $_POST['dateStart'] && $_POST['dateEnd']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM mou WHERE Mo_type=1 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired= '" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ที่มีการลงนามในวันที่'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . DateThai($_POST['dateStart']) . ' หรือหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateInsert'] && $_POST['dateDelect']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM mou WHERE Mo_type=1 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' ORDER BY dates_tr ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ซึ่งมีข้อมูลทั้งหมด'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart'] && $_POST['dateEnd']) {
                $sql = "SELECT * FROM mou WHERE Mo_type=1 AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired='" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' หรือวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart']) {
                $sql = "SELECT * FROM mou WHERE Mo_type=1 AND dateStart='" . $_POST['dateStart'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateEnd']) {
                $sql = "SELECT * FROM mou WHERE Mo_type=1 AND dateExpired='" . $_POST['dateEnd'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } else {
                $sql = "SELECT * FROM mou WHERE Mo_type=1 ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดยรายงานข้อมูลนี้เป็นข้อมูลการทำความร่วมมือทั้งหมด ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตาราง'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง
            }

        } elseif ($_POST['Mo_type'] == "2") {
            $pdf->SetFont('THSarabunNew', '', 16);
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'เรื่อง บันทึกการลงนามความร่วมมือ ประเภทบันทึกความเข้าใจทางวิชาการ (MOU)'), 0, 1, 'C');
            $pdf->Ln(1); // เพิ่มระยะห่าง
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ของหน่วยงานทั้งหมดในมหาวิทยาลัยเทคโนโลยีราชมงคลอีสานทุกวิทยาเขต'), 0, 1, 'C');
            $pdf->Ln(8); // เพิ่มระยะห่าง

            if ($_POST['dateInsert'] && $_POST['dateDelect'] && $_POST['dateStart'] && $_POST['dateEnd']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM mou WHERE Mo_type=2 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired= '" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ที่มีการลงนามในวันที่'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . DateThai($_POST['dateStart']) . ' หรือหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateInsert'] && $_POST['dateDelect']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM mou WHERE Mo_type=2 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' ORDER BY dates_tr ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ซึ่งมีข้อมูลทั้งหมด'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart'] && $_POST['dateEnd']) {
                $sql = "SELECT * FROM mou WHERE Mo_type=2 AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired='" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' หรือวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart']) {
                $sql = "SELECT * FROM mou WHERE Mo_type=2 AND dateStart='" . $_POST['dateStart'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateEnd']) {
                $sql = "SELECT * FROM mou WHERE Mo_type=2 AND dateExpired='" . $_POST['dateEnd'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } else {
                $sql = "SELECT * FROM mou WHERE Mo_type=2 ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดยรายงานข้อมูลนี้เป็นข้อมูลการทำความร่วมมือทั้งหมด ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตาราง'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง
            }

        } elseif ($_POST['Mo_type'] == "3") {
            $pdf->SetFont('THSarabunNew', '', 16);
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'เรื่อง บันทึกการลงนามความร่วมมือ ประเภทบันทึกข้อตกลงความร่วมมือทางวิชาการ (MOA)'), 0, 1, 'C');
            $pdf->Ln(1); // เพิ่มระยะห่าง
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ของหน่วยงานทั้งหมดในมหาวิทยาลัยเทคโนโลยีราชมงคลอีสานทุกวิทยาเขต'), 0, 1, 'C');
            $pdf->Ln(8); // เพิ่มระยะห่าง

            if ($_POST['dateInsert'] && $_POST['dateDelect'] && $_POST['dateStart'] && $_POST['dateEnd']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM mou WHERE Mo_type=3 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired= '" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ที่มีการลงนามในวันที่'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . DateThai($_POST['dateStart']) . ' หรือหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateInsert'] && $_POST['dateDelect']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM mou WHERE Mo_type=3 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' ORDER BY dates_tr ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ซึ่งมีข้อมูลทั้งหมด'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart'] && $_POST['dateEnd']) {
                $sql = "SELECT * FROM mou WHERE Mo_type=3 AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired='" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' หรือวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart']) {
                $sql = "SELECT * FROM mou WHERE Mo_type=3 AND dateStart='" . $_POST['dateStart'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateEnd']) {
                $sql = "SELECT * FROM mou WHERE Mo_type=3 AND dateExpired='" . $_POST['dateEnd'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } else {
                $sql = "SELECT * FROM mou WHERE Mo_type=3 ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดยรายงานข้อมูลนี้เป็นข้อมูลการทำความร่วมมือทั้งหมด ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตาราง'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง
            }

        }
    } elseif ($_POST['ag_id'] == "korat") { //ไม่มีการเลือกหน่วยงานไหนเลย
        //ตรวจสอบการเลือกประเภทของบันทึกความร่วมมือ
        if ($_POST['Mo_type'] == "all") {
            $pdf->SetFont('THSarabunNew', '', 16);
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'เรื่อง บันทึกการลงนามความร่วมมือทุกประเภทความร่วมมือ'), 0, 1, 'C');
            $pdf->Ln(1); // เพิ่มระยะห่าง
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'หน่วยงานทั้งหมดในมหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน ศูนย์กลางนครราชสีมา'), 0, 1, 'C');
            $pdf->Ln(8); // เพิ่มระยะห่าง

            if ($_POST['dateInsert'] && $_POST['dateDelect'] && $_POST['dateStart'] && $_POST['dateEnd']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM report_view WHERE campus=1 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired= '" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ที่มีการลงนามในวันที่'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . DateThai($_POST['dateStart']) . ' หรือหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดย   MOI หมายถึง บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOU หมายถึง บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOA หมายถึง บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement)'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateInsert'] && $_POST['dateDelect']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM report_view WHERE campus=1 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' ORDER BY dates_tr ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ซึ่งมีข้อมูลทั้งหมด'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดย   MOI หมายถึง บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOU หมายถึง บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOA หมายถึง บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement)'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart'] && $_POST['dateEnd']) {
                $sql = "SELECT * FROM report_view WHERE campus=1 AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired='" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' หรือวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดย   MOI หมายถึง บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOU หมายถึง บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOA หมายถึง บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement)'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart']) {
                $sql = "SELECT * FROM report_view WHERE campus=1  AND dateStart='" . $_POST['dateStart'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดย   MOI หมายถึง บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOU หมายถึง บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOA หมายถึง บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement)'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateEnd']) {
                $sql = "SELECT * FROM report_view WHERE campus=1 AND dateExpired='" . $_POST['dateEnd'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดย   MOI หมายถึง บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOU หมายถึง บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOA หมายถึง บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement)'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } else {
                $sql = "SELECT * FROM report_view WHERE campus=1 ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดยรายงานข้อมูลนี้เป็นข้อมูลการทำความร่วมมือทั้งหมด ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตาราง'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดย   MOI หมายถึง บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOU หมายถึง บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOA หมายถึง บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement)'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง
            }

        } elseif ($_POST['Mo_type'] == "1") {
            $pdf->SetFont('THSarabunNew', '', 16);
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'เรื่อง บันทึกการลงนามความร่วมมือ ประเภทบันทึกแสดงเจตจํานงทางวิชาการ (MOI)'), 0, 1, 'C');
            $pdf->Ln(1); // เพิ่มระยะห่าง
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'หน่วยงานทั้งหมดในมหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน ศูนย์กลางนครราชสีมา'), 0, 1, 'C');
            $pdf->Ln(8); // เพิ่มระยะห่าง

            if ($_POST['dateInsert'] && $_POST['dateDelect'] && $_POST['dateStart'] && $_POST['dateEnd']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM report_view WHERE campus=1 AND Mo_type=1 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired= '" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ที่มีการลงนามในวันที่'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . DateThai($_POST['dateStart']) . ' หรือหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateInsert'] && $_POST['dateDelect']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM report_view WHERE campus=1 AND Mo_type=1 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' ORDER BY dates_tr ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ซึ่งมีข้อมูลทั้งหมด'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart'] && $_POST['dateEnd']) {
                $sql = "SELECT * FROM report_view WHERE campus=1 AND Mo_type=1 AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired='" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' หรือวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart']) {
                $sql = "SELECT * FROM report_view WHERE campus=1 AND Mo_type=1 AND dateStart='" . $_POST['dateStart'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateEnd']) {
                $sql = "SELECT * FROM report_view WHERE campus=1 AND Mo_type=1 AND dateExpired='" . $_POST['dateEnd'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } else {
                $sql = "SELECT * FROM report_view WHERE campus=1 AND Mo_type=1 ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดยรายงานข้อมูลนี้เป็นข้อมูลการทำความร่วมมือทั้งหมด ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตาราง'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง
            }

        } elseif ($_POST['Mo_type'] == "2") {
            $pdf->SetFont('THSarabunNew', '', 16);
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'เรื่อง บันทึกการลงนามความร่วมมือ ประเภทบันทึกความเข้าใจทางวิชาการ (MOU)'), 0, 1, 'C');
            $pdf->Ln(1); // เพิ่มระยะห่าง
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'หน่วยงานทั้งหมดในมหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน ศูนย์กลางนครราชสีมา'), 0, 1, 'C');
            $pdf->Ln(8); // เพิ่มระยะห่าง

            if ($_POST['dateInsert'] && $_POST['dateDelect'] && $_POST['dateStart'] && $_POST['dateEnd']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM report_view WHERE campus=1 AND Mo_type=2 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired= '" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ที่มีการลงนามในวันที่'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . DateThai($_POST['dateStart']) . ' หรือหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateInsert'] && $_POST['dateDelect']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM report_view WHERE campus=1 AND Mo_type=2 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' ORDER BY dates_tr ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ซึ่งมีข้อมูลทั้งหมด'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart'] && $_POST['dateEnd']) {
                $sql = "SELECT * FROM report_view WHERE campus=1 AND Mo_type=2 AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired='" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' หรือวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart']) {
                $sql = "SELECT * FROM report_view WHERE campus=1 AND Mo_type=2 AND dateStart='" . $_POST['dateStart'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateEnd']) {
                $sql = "SELECT * FROM report_view WHERE campus=1 AND Mo_type=2 AND dateExpired='" . $_POST['dateEnd'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } else {
                $sql = "SELECT * FROM report_view WHERE campus=1 AND Mo_type=2 ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดยรายงานข้อมูลนี้เป็นข้อมูลการทำความร่วมมือทั้งหมด ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตาราง'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง
            }

        } elseif ($_POST['Mo_type'] == "3") {
            $pdf->SetFont('THSarabunNew', '', 16);
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'เรื่อง บันทึกการลงนามความร่วมมือ ประเภทบันทึกข้อตกลงความร่วมมือทางวิชาการ (MOA)'), 0, 1, 'C');
            $pdf->Ln(1); // เพิ่มระยะห่าง
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'หน่วยงานทั้งหมดในมหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน ศูนย์กลางนครราชสีมา'), 0, 1, 'C');
            $pdf->Ln(8); // เพิ่มระยะห่าง

            if ($_POST['dateInsert'] && $_POST['dateDelect'] && $_POST['dateStart'] && $_POST['dateEnd']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM report_view WHERE campus=1 AND Mo_type=3 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired= '" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ที่มีการลงนามในวันที่'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . DateThai($_POST['dateStart']) . ' หรือหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateInsert'] && $_POST['dateDelect']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM report_view WHERE campus=1 AND Mo_type=3 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' ORDER BY dates_tr ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ซึ่งมีข้อมูลทั้งหมด'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart'] && $_POST['dateEnd']) {
                $sql = "SELECT * FROM report_view WHERE campus=1 AND Mo_type=3 AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired='" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' หรือวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart']) {
                $sql = "SELECT * FROM report_view WHERE campus=1 AND Mo_type=3 AND dateStart='" . $_POST['dateStart'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateEnd']) {
                $sql = "SELECT * FROM report_view WHERE campus=1 AND Mo_type=3 AND dateExpired='" . $_POST['dateEnd'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } else {
                $sql = "SELECT * FROM report_view WHERE campus=1 AND Mo_type=3 ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดยรายงานข้อมูลนี้เป็นข้อมูลการทำความร่วมมือทั้งหมด ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตาราง'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง
            }

        }
    } elseif ($_POST['ag_id'] == "khonkean") { //ไม่มีการเลือกหน่วยงานไหนเลย
        //ตรวจสอบการเลือกประเภทของบันทึกความร่วมมือ
        if ($_POST['Mo_type'] == "all") {
            $pdf->SetFont('THSarabunNew', '', 16);
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'เรื่อง บันทึกการลงนามความร่วมมือทุกประเภทความร่วมมือ'), 0, 1, 'C');
            $pdf->Ln(1); // เพิ่มระยะห่าง
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'หน่วยงานทั้งหมดในมหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน วิทยาเขตขอนแก่น'), 0, 1, 'C');
            $pdf->Ln(8); // เพิ่มระยะห่าง

            if ($_POST['dateInsert'] && $_POST['dateDelect'] && $_POST['dateStart'] && $_POST['dateEnd']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM report_view WHERE campus=2  AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired= '" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ที่มีการลงนามในวันที่'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . DateThai($_POST['dateStart']) . ' หรือหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดย   MOI หมายถึง บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOU หมายถึง บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOA หมายถึง บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement)'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateInsert'] && $_POST['dateDelect']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM report_view WHERE campus=2 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' ORDER BY dates_tr ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ซึ่งมีข้อมูลทั้งหมด'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดย   MOI หมายถึง บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOU หมายถึง บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOA หมายถึง บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement)'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart'] && $_POST['dateEnd']) {
                $sql = "SELECT * FROM report_view WHERE campus=2 AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired='" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' หรือวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดย   MOI หมายถึง บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOU หมายถึง บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOA หมายถึง บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement)'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart']) {
                $sql = "SELECT * FROM report_view WHERE campus=2  AND dateStart='" . $_POST['dateStart'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดย   MOI หมายถึง บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOU หมายถึง บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOA หมายถึง บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement)'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateEnd']) {
                $sql = "SELECT * FROM report_view WHERE campus=2 AND dateExpired='" . $_POST['dateEnd'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดย   MOI หมายถึง บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOU หมายถึง บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOA หมายถึง บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement)'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } else {
                $sql = "SELECT * FROM report_view WHERE campus=2 ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดยรายงานข้อมูลนี้เป็นข้อมูลการทำความร่วมมือทั้งหมด ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตาราง'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดย   MOI หมายถึง บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOU หมายถึง บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOA หมายถึง บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement)'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง
            }

        } elseif ($_POST['Mo_type'] == "1") {
            $pdf->SetFont('THSarabunNew', '', 16);
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'เรื่อง บันทึกการลงนามความร่วมมือ ประเภทบันทึกแสดงเจตจํานงทางวิชาการ (MOI)'), 0, 1, 'C');
            $pdf->Ln(1); // เพิ่มระยะห่าง
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'หน่วยงานทั้งหมดในมหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน วิทยาเขตขอนแก่น'), 0, 1, 'C');
            $pdf->Ln(8); // เพิ่มระยะห่าง

            if ($_POST['dateInsert'] && $_POST['dateDelect'] && $_POST['dateStart'] && $_POST['dateEnd']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM report_view WHERE campus=2 AND Mo_type=1 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired= '" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ที่มีการลงนามในวันที่'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . DateThai($_POST['dateStart']) . ' หรือหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateInsert'] && $_POST['dateDelect']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM report_view WHERE campus=2 AND Mo_type=1 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' ORDER BY dates_tr ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ซึ่งมีข้อมูลทั้งหมด'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart'] && $_POST['dateEnd']) {
                $sql = "SELECT * FROM report_view WHERE campus=2 AND Mo_type=1 AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired='" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' หรือวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart']) {
                $sql = "SELECT * FROM report_view WHERE campus=2 AND Mo_type=1 AND dateStart='" . $_POST['dateStart'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateEnd']) {
                $sql = "SELECT * FROM report_view WHERE campus=2 AND Mo_type=1 AND dateExpired='" . $_POST['dateEnd'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } else {
                $sql = "SELECT * FROM report_view WHERE campus=2 AND Mo_type=1 ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดยรายงานข้อมูลนี้เป็นข้อมูลการทำความร่วมมือทั้งหมด ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตาราง'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง
            }

        } elseif ($_POST['Mo_type'] == "2") {
            $pdf->SetFont('THSarabunNew', '', 16);
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'เรื่อง บันทึกการลงนามความร่วมมือ ประเภทบันทึกความเข้าใจทางวิชาการ (MOU)'), 0, 1, 'C');
            $pdf->Ln(1); // เพิ่มระยะห่าง
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'หน่วยงานทั้งหมดในมหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน วิทยาเขตขอนแก่น'), 0, 1, 'C');
            $pdf->Ln(8); // เพิ่มระยะห่าง

            if ($_POST['dateInsert'] && $_POST['dateDelect'] && $_POST['dateStart'] && $_POST['dateEnd']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM report_view WHERE campus=2 AND Mo_type=2 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired= '" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ที่มีการลงนามในวันที่'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . DateThai($_POST['dateStart']) . ' หรือหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateInsert'] && $_POST['dateDelect']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM report_view WHERE campus=2 AND Mo_type=2 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' ORDER BY dates_tr ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ซึ่งมีข้อมูลทั้งหมด'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart'] && $_POST['dateEnd']) {
                $sql = "SELECT * FROM report_view WHERE campus=2 AND Mo_type=2 AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired='" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' หรือวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart']) {
                $sql = "SELECT * FROM report_view WHERE campus=2 AND Mo_type=2 AND dateStart='" . $_POST['dateStart'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateEnd']) {
                $sql = "SELECT * FROM report_view WHERE campus=2 AND Mo_type=2 AND dateExpired='" . $_POST['dateEnd'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } else {
                $sql = "SELECT * FROM report_view WHERE campus=2 AND Mo_type=2 ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดยรายงานข้อมูลนี้เป็นข้อมูลการทำความร่วมมือทั้งหมด ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตาราง'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง
            }

        } elseif ($_POST['Mo_type'] == "3") {
            $pdf->SetFont('THSarabunNew', '', 16);
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'เรื่อง บันทึกการลงนามความร่วมมือ ประเภทบันทึกข้อตกลงความร่วมมือทางวิชาการ (MOA)'), 0, 1, 'C');
            $pdf->Ln(1); // เพิ่มระยะห่าง
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'หน่วยงานทั้งหมดในมหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน วิทยาเขตขอนแก่น'), 0, 1, 'C');
            $pdf->Ln(8); // เพิ่มระยะห่าง

            if ($_POST['dateInsert'] && $_POST['dateDelect'] && $_POST['dateStart'] && $_POST['dateEnd']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM report_view WHERE campus=2 AND Mo_type=3 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired= '" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ที่มีการลงนามในวันที่'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . DateThai($_POST['dateStart']) . ' หรือหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateInsert'] && $_POST['dateDelect']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM report_view WHERE campus=2 AND Mo_type=3 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' ORDER BY dates_tr ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ซึ่งมีข้อมูลทั้งหมด'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart'] && $_POST['dateEnd']) {
                $sql = "SELECT * FROM report_view WHERE campus=2 AND Mo_type=3 AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired='" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' หรือวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart']) {
                $sql = "SELECT * FROM report_view WHERE campus=2 AND Mo_type=3 AND dateStart='" . $_POST['dateStart'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateEnd']) {
                $sql = "SELECT * FROM report_view WHERE campus=2 AND Mo_type=3 AND dateExpired='" . $_POST['dateEnd'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } else {
                $sql = "SELECT * FROM report_view WHERE campus=2 AND Mo_type=3 ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดยรายงานข้อมูลนี้เป็นข้อมูลการทำความร่วมมือทั้งหมด ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตาราง'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง
            }
        }
    } elseif ($_POST['ag_id'] == "sakonnakhon") { //ไม่มีการเลือกหน่วยงานไหนเลย
        //ตรวจสอบการเลือกประเภทของบันทึกความร่วมมือ
        if ($_POST['Mo_type'] == "all") {
            $pdf->SetFont('THSarabunNew', '', 16);
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'เรื่อง บันทึกการลงนามความร่วมมือทุกประเภทความร่วมมือ'), 0, 1, 'C');
            $pdf->Ln(1); // เพิ่มระยะห่าง
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'หน่วยงานทั้งหมดในมหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน วิทยาเขตสกลนคร'), 0, 1, 'C');
            $pdf->Ln(8); // เพิ่มระยะห่าง

            if ($_POST['dateInsert'] && $_POST['dateDelect'] && $_POST['dateStart'] && $_POST['dateEnd']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM report_view WHERE campus=3  AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired= '" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ที่มีการลงนามในวันที่'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . DateThai($_POST['dateStart']) . ' หรือหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดย   MOI หมายถึง บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOU หมายถึง บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOA หมายถึง บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement)'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateInsert'] && $_POST['dateDelect']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM report_view WHERE campus=3 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' ORDER BY dates_tr ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ซึ่งมีข้อมูลทั้งหมด'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดย   MOI หมายถึง บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOU หมายถึง บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOA หมายถึง บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement)'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart'] && $_POST['dateEnd']) {
                $sql = "SELECT * FROM report_view WHERE campus=3 AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired='" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' หรือวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดย   MOI หมายถึง บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOU หมายถึง บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOA หมายถึง บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement)'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart']) {
                $sql = "SELECT * FROM report_view WHERE campus=3 AND dateStart='" . $_POST['dateStart'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดย   MOI หมายถึง บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOU หมายถึง บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOA หมายถึง บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement)'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateEnd']) {
                $sql = "SELECT * FROM report_view WHERE campus=3 AND dateExpired='" . $_POST['dateEnd'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดย   MOI หมายถึง บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOU หมายถึง บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOA หมายถึง บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement)'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } else {
                $sql = "SELECT * FROM report_view WHERE campus=3 ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดยรายงานข้อมูลนี้เป็นข้อมูลการทำความร่วมมือทั้งหมด ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตาราง'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดย   MOI หมายถึง บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOU หมายถึง บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOA หมายถึง บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement)'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง
            }

        } elseif ($_POST['Mo_type'] == "1") {
            $pdf->SetFont('THSarabunNew', '', 16);
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'เรื่อง บันทึกการลงนามความร่วมมือ ประเภทบันทึกแสดงเจตจํานงทางวิชาการ (MOI)'), 0, 1, 'C');
            $pdf->Ln(1); // เพิ่มระยะห่าง
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'หน่วยงานทั้งหมดในมหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน วิทยาเขตสกลนคร'), 0, 1, 'C');
            $pdf->Ln(8); // เพิ่มระยะห่าง

            if ($_POST['dateInsert'] && $_POST['dateDelect'] && $_POST['dateStart'] && $_POST['dateEnd']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM report_view WHERE campus=3 AND Mo_type=1 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired= '" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ที่มีการลงนามในวันที่'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . DateThai($_POST['dateStart']) . ' หรือหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateInsert'] && $_POST['dateDelect']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM report_view WHERE campus=3 AND Mo_type=1 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' ORDER BY dates_tr ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ซึ่งมีข้อมูลทั้งหมด'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart'] && $_POST['dateEnd']) {
                $sql = "SELECT * FROM report_view WHERE campus=3 AND Mo_type=1 AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired='" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' หรือวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart']) {
                $sql = "SELECT * FROM report_view WHERE campus=3 AND Mo_type=1 AND dateStart='" . $_POST['dateStart'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateEnd']) {
                $sql = "SELECT * FROM report_view WHERE campus=3 AND Mo_type=1 AND dateExpired='" . $_POST['dateEnd'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } else {
                $sql = "SELECT * FROM report_view WHERE campus=3 AND Mo_type=1 ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดยรายงานข้อมูลนี้เป็นข้อมูลการทำความร่วมมือทั้งหมด ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตาราง'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง
            }

        } elseif ($_POST['Mo_type'] == "2") {
            $pdf->SetFont('THSarabunNew', '', 16);
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'เรื่อง บันทึกการลงนามความร่วมมือ ประเภทบันทึกความเข้าใจทางวิชาการ (MOU)'), 0, 1, 'C');
            $pdf->Ln(1); // เพิ่มระยะห่าง
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'หน่วยงานทั้งหมดในมหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน วิทยาเขตสกลนคร'), 0, 1, 'C');
            $pdf->Ln(8); // เพิ่มระยะห่าง

            if ($_POST['dateInsert'] && $_POST['dateDelect'] && $_POST['dateStart'] && $_POST['dateEnd']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM report_view WHERE campus=3 AND Mo_type=2 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired= '" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ที่มีการลงนามในวันที่'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . DateThai($_POST['dateStart']) . ' หรือหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateInsert'] && $_POST['dateDelect']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM report_view WHERE campus=3 AND Mo_type=2 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' ORDER BY dates_tr ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ซึ่งมีข้อมูลทั้งหมด'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart'] && $_POST['dateEnd']) {
                $sql = "SELECT * FROM report_view WHERE campus=3 AND Mo_type=2 AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired='" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' หรือวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart']) {
                $sql = "SELECT * FROM report_view WHERE campus=3 AND Mo_type=2 AND dateStart='" . $_POST['dateStart'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateEnd']) {
                $sql = "SELECT * FROM report_view WHERE campus=3 AND Mo_type=2 AND dateExpired='" . $_POST['dateEnd'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } else {
                $sql = "SELECT * FROM report_view WHERE campus=3 AND Mo_type=2 ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดยรายงานข้อมูลนี้เป็นข้อมูลการทำความร่วมมือทั้งหมด ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตาราง'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง
            }

        } elseif ($_POST['Mo_type'] == "3") {
            $pdf->SetFont('THSarabunNew', '', 16);
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'เรื่อง บันทึกการลงนามความร่วมมือ ประเภทบันทึกข้อตกลงความร่วมมือทางวิชาการ (MOA)'), 0, 1, 'C');
            $pdf->Ln(1); // เพิ่มระยะห่าง
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'หน่วยงานทั้งหมดในมหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน วิทยาเขตสกลนคร'), 0, 1, 'C');
            $pdf->Ln(8); // เพิ่มระยะห่าง

            if ($_POST['dateInsert'] && $_POST['dateDelect'] && $_POST['dateStart'] && $_POST['dateEnd']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM report_view WHERE campus=3 AND Mo_type=3 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired= '" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ที่มีการลงนามในวันที่'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . DateThai($_POST['dateStart']) . ' หรือหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateInsert'] && $_POST['dateDelect']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM report_view WHERE campus=3 AND Mo_type=3 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' ORDER BY dates_tr ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ซึ่งมีข้อมูลทั้งหมด'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart'] && $_POST['dateEnd']) {
                $sql = "SELECT * FROM report_view WHERE campus=3 AND Mo_type=3 AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired='" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' หรือวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart']) {
                $sql = "SELECT * FROM report_view WHERE campus=3 AND Mo_type=3 AND dateStart='" . $_POST['dateStart'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateEnd']) {
                $sql = "SELECT * FROM report_view WHERE campus=3 AND Mo_type=3 AND dateExpired='" . $_POST['dateEnd'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } else {
                $sql = "SELECT * FROM report_view WHERE campus=3 AND Mo_type=3 ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดยรายงานข้อมูลนี้เป็นข้อมูลการทำความร่วมมือทั้งหมด ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตาราง'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง
            }

        }
    } elseif ($_POST['ag_id'] == "surin") { //ไม่มีการเลือกหน่วยงานไหนเลย
        //ตรวจสอบการเลือกประเภทของบันทึกความร่วมมือ
        if ($_POST['Mo_type'] == "all") {
            $pdf->SetFont('THSarabunNew', '', 16);
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'เรื่อง บันทึกการลงนามความร่วมมือทุกประเภทความร่วมมือ'), 0, 1, 'C');
            $pdf->Ln(1); // เพิ่มระยะห่าง
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'หน่วยงานทั้งหมดในมหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน วิทยาเขตสุรินทร์'), 0, 1, 'C');
            $pdf->Ln(8); // เพิ่มระยะห่าง

            if ($_POST['dateInsert'] && $_POST['dateDelect'] && $_POST['dateStart'] && $_POST['dateEnd']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM report_view WHERE campus=4  AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired= '" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ที่มีการลงนามในวันที่'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . DateThai($_POST['dateStart']) . ' หรือหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดย   MOI หมายถึง บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOU หมายถึง บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOA หมายถึง บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement)'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateInsert'] && $_POST['dateDelect']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM report_view WHERE campus=4 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' ORDER BY dates_tr ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ซึ่งมีข้อมูลทั้งหมด'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดย   MOI หมายถึง บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOU หมายถึง บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOA หมายถึง บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement)'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart'] && $_POST['dateEnd']) {
                $sql = "SELECT * FROM report_view WHERE campus=4 AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired='" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' หรือวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดย   MOI หมายถึง บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOU หมายถึง บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOA หมายถึง บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement)'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart']) {
                $sql = "SELECT * FROM report_view WHERE campus=4  AND dateStart='" . $_POST['dateStart'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดย   MOI หมายถึง บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOU หมายถึง บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOA หมายถึง บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement)'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateEnd']) {
                $sql = "SELECT * FROM report_view WHERE campus=4 AND dateExpired='" . $_POST['dateEnd'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดย   MOI หมายถึง บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOU หมายถึง บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOA หมายถึง บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement)'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } else {
                $sql = "SELECT * FROM report_view WHERE campus=4 ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $numrow = $result->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดยรายงานข้อมูลนี้เป็นข้อมูลการทำความร่วมมือทั้งหมด ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตาราง'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดย   MOI หมายถึง บันทึกแสดงเจตจํานงทางวิชาการ (Memorandum of Intent)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOU หมายถึง บันทึกความเข้าใจทางวิชาการ (Memorandum of Understanding)'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                        MOA หมายถึง บันทึกข้อตกลงความร่วมมือทางวิชาการ (Memorandum of Agreement)'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง
            }

        } elseif ($_POST['Mo_type'] == "1") {
            $pdf->SetFont('THSarabunNew', '', 16);
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'เรื่อง บันทึกการลงนามความร่วมมือ ประเภทบันทึกแสดงเจตจํานงทางวิชาการ (MOI)'), 0, 1, 'C');
            $pdf->Ln(1); // เพิ่มระยะห่าง
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'หน่วยงานทั้งหมดในมหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน วิทยาเขตสุรินทร์'), 0, 1, 'C');
            $pdf->Ln(8); // เพิ่มระยะห่าง

            if ($_POST['dateInsert'] && $_POST['dateDelect'] && $_POST['dateStart'] && $_POST['dateEnd']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM report_view WHERE campus=4 AND Mo_type=1 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired= '" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ที่มีการลงนามในวันที่'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . DateThai($_POST['dateStart']) . ' หรือหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateInsert'] && $_POST['dateDelect']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM report_view WHERE campus=4 AND Mo_type=1 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' ORDER BY dates_tr ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ซึ่งมีข้อมูลทั้งหมด'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart'] && $_POST['dateEnd']) {
                $sql = "SELECT * FROM report_view WHERE campus=4 AND Mo_type=1 AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired='" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' หรือวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart']) {
                $sql = "SELECT * FROM report_view WHERE campus=4 AND Mo_type=1 AND dateStart='" . $_POST['dateStart'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateEnd']) {
                $sql = "SELECT * FROM report_view WHERE campus=4 AND Mo_type=1 AND dateExpired='" . $_POST['dateEnd'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } else {
                $sql = "SELECT * FROM report_view WHERE campus=4 AND Mo_type=1 ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดยรายงานข้อมูลนี้เป็นข้อมูลการทำความร่วมมือทั้งหมด ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตาราง'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง
            }

        } elseif ($_POST['Mo_type'] == "2") {
            $pdf->SetFont('THSarabunNew', '', 16);
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'เรื่อง บันทึกการลงนามความร่วมมือ ประเภทบันทึกความเข้าใจทางวิชาการ (MOU)'), 0, 1, 'C');
            $pdf->Ln(1); // เพิ่มระยะห่าง
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'หน่วยงานทั้งหมดในมหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน วิทยาเขตสุรินทร์'), 0, 1, 'C');
            $pdf->Ln(8); // เพิ่มระยะห่าง

            if ($_POST['dateInsert'] && $_POST['dateDelect'] && $_POST['dateStart'] && $_POST['dateEnd']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM report_view WHERE campus=4 AND Mo_type=2 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired= '" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ที่มีการลงนามในวันที่'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . DateThai($_POST['dateStart']) . ' หรือหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateInsert'] && $_POST['dateDelect']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM report_view WHERE campus=4 AND Mo_type=2 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' ORDER BY dates_tr ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ซึ่งมีข้อมูลทั้งหมด'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart'] && $_POST['dateEnd']) {
                $sql = "SELECT * FROM report_view WHERE campus=4 AND Mo_type=2 AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired='" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' หรือวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart']) {
                $sql = "SELECT * FROM report_view WHERE campus=4 AND Mo_type=2 AND dateStart='" . $_POST['dateStart'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateEnd']) {
                $sql = "SELECT * FROM report_view WHERE campus=4 AND Mo_type=2 AND dateExpired='" . $_POST['dateEnd'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } else {
                $sql = "SELECT * FROM report_view WHERE campus=4 AND Mo_type=2 ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดยรายงานข้อมูลนี้เป็นข้อมูลการทำความร่วมมือทั้งหมด ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตาราง'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง
            }

        } elseif ($_POST['Mo_type'] == "3") {
            $pdf->SetFont('THSarabunNew', '', 16);
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'เรื่อง บันทึกการลงนามความร่วมมือ ประเภทบันทึกข้อตกลงความร่วมมือทางวิชาการ (MOA)'), 0, 1, 'C');
            $pdf->Ln(1); // เพิ่มระยะห่าง
            $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'หน่วยงานทั้งหมดในมหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน วิทยาเขตขอนแก่น'), 0, 1, 'C');
            $pdf->Ln(8); // เพิ่มระยะห่าง

            if ($_POST['dateInsert'] && $_POST['dateDelect'] && $_POST['dateStart'] && $_POST['dateEnd']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM report_view WHERE campus=4 AND Mo_type=3 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired= '" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ที่มีการลงนามในวันที่'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . DateThai($_POST['dateStart']) . ' หรือหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateInsert'] && $_POST['dateDelect']) {
                //คำสั่ง sql หาข้อมูลตามเงื่อนไขที่เลือก
                $sql = "SELECT * FROM report_view WHERE campus=4 AND Mo_type=3 AND dates_tr BETWEEN '" . $_POST['dateInsert'] . "' AND '" . $_POST['dateDelect'] . "' ORDER BY dates_tr ASC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีการเพิ่มข้อมูลระหว่างวันที่ ' . DateThai($_POST['dateInsert']) . ' ถึง ' . DateThai($_POST['dateDelect']) . ' ซึ่งมีข้อมูลทั้งหมด'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart'] && $_POST['dateEnd']) {
                $sql = "SELECT * FROM report_view WHERE campus=4 AND Mo_type=3 AND dateStart='" . $_POST['dateStart'] . "' OR dateExpired='" . $_POST['dateEnd'] . "' ORDER BY dateStart ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' หรือวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateStart']) {
                $sql = "SELECT * FROM report_view WHERE campus=4 AND Mo_type=3 AND dateStart='" . $_POST['dateStart'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันที่ลงนามในวันที่ ' . DateThai($_POST['dateStart']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } elseif ($_POST['dateEnd']) {
                $sql = "SELECT * FROM report_view WHERE campus=4 AND Mo_type=3 AND dateExpired='" . $_POST['dateEnd'] . "' ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                รายงานข้อมูลนี้มีวันหมดอายุในวันที่ ' . DateThai($_POST['dateEnd']) . ' ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตารางข้อมูล'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง

            } else {
                $sql = "SELECT * FROM report_view WHERE campus=4 AND Mo_type=3 ORDER BY mouid ASC";
                $excute = mysqli_query($conn, $sql);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $query = $stmt->get_result();
                $numrow = $query->num_rows; //นับจำนวนข้อมูล
                //แสดงรายละเอียดก่อนตาราง
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', '                โดยรายงานข้อมูลนี้เป็นข้อมูลการทำความร่วมมือทั้งหมด ซึ่งมีข้อมูลทั้งหมด ' . $numrow . ' รายการ แสดงเป็นตาราง'), 0, 1, 'L');
                $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ข้อมูลได้ดังนี้'), 0, 1, 'L');
                $pdf->Ln(8); // เพิ่มระยะห่าง
            }
        }
    }
}

if ($result) {
    if ($result->num_rows > 0) {
        //รันลำดับอัตโนมัติ
        $i = 1;
        // สร้างหัวตาราง
        $pdf->SetFont('THSarabunNew', '', 12);
        $header = ['ที่', 'ชื่อบันทึกความร่วมมือ', 'ประเภท', 'หน่วยงานที่มีความร่วมมือ', 'หน่วยงาน/สถาบัน', 'ระยะเวลา', 'วันที่ลงนาม', 'วันหมดอายุ'];

        // ปรับความกว้างของเซลล์
        $cellWidths = [10, 35, 14, 35, 22, 15, 25, 25];

        // คำนวณความกว้างรวมของตาราง
        $totalWidth = array_sum($cellWidths);
        // คำนวณระยะห่างด้านซ้ายเพื่อให้ตารางอยู่ตรงกลาง
        $startX = ($pdf->GetPageWidth() - $totalWidth) / 2;

        // สร้างหัวตาราง
        $pdf->SetX($startX); // กำหนดตำแหน่งเริ่มต้นของตาราง
        foreach ($header as $key => $col) {
            $pdf->Cell($cellWidths[$key], 10, iconv('UTF-8', 'TIS-620', $col), 1, 0, 'C');
        }
        $pdf->Ln();

        $statusList = array("1" => "MOI", "2" => "MOU", "3" => "MOA");
        $statusList1 = array("1" => "ในประเทศ", "2" => "ต่างประเทศ");

        // เพิ่มข้อมูลลงในตาราง
        while ($row = $result->fetch_assoc()) {
            $pdf->SetX($startX); // ตั้งค่าตำแหน่งเริ่มต้นให้ตรงกลาง
            $pdf->Cell($cellWidths[0], 10, iconv('UTF-8', 'TIS-620', $i++), 1, 0, 'C');
            $pdf->Cell($cellWidths[1], 10, iconv('UTF-8', 'TIS-620', $row['nameMou']), 1, 0, 'C');
            $pdf->Cell($cellWidths[2], 10, iconv('UTF-8', 'TIS-620', $statusList[$row['Mo_type']]), 1, 0, 'C');
            $pdf->Cell($cellWidths[3], 10, iconv('UTF-8', 'TIS-620', $row['deptNameCo']), 1, 0, 'C');
            $pdf->Cell($cellWidths[4], 10, iconv('UTF-8', 'TIS-620', $statusList1[$row['department']]), 1, 0, 'C');
            $pdf->Cell($cellWidths[5], 10, iconv('UTF-8', 'TIS-620', '' . $row['time_mou'] . ' ปี'), 1, 0, 'C');
            $pdf->Cell($cellWidths[6], 10, iconv('UTF-8', 'TIS-620', DateThai($row['dateStart'])), 1, 0, 'C');
            $pdf->Cell($cellWidths[7], 10, iconv('UTF-8', 'TIS-620', DateThai($row['dateExpired'])), 1, 0, 'C');
            $pdf->Ln();
        }
    } else {
        $pdf->SetFont('THSarabunNew', '', 16);
        $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ไม่มีข้อมูลที่ตรงตามเงื่อนไขที่เลือก'), 0, 1, 'C');
    }

} elseif ($query) {
    if ($query->num_rows > 0) {
        //รันลำดับอัตโนมัติ
        $i = 1;
        // สร้างหัวตาราง
        $pdf->SetFont('THSarabunNew', '', 12);
        $header = ['ที่', 'ชื่อบันทึกความร่วมมือ', 'หน่วยงานที่ดำเนินการ', 'หน่วยงานที่มีความร่วมมือ', 'หน่วยงาน/สถาบัน', 'ระยะเวลา', 'วันที่ลงนาม', 'วันหมดอายุ'];

        // ปรับความกว้างของเซลล์
        $cellWidths = [10, 35, 30, 35, 22, 15, 25, 25];

        // คำนวณความกว้างรวมของตาราง
        $totalWidth = array_sum($cellWidths);
        // คำนวณระยะห่างด้านซ้ายเพื่อให้ตารางอยู่ตรงกลาง
        $startX = ($pdf->GetPageWidth() - $totalWidth) / 2;

        $pdf->SetX($startX); // กำหนดตำแหน่งเริ่มต้นของตาราง
        foreach ($header as $key => $col) {
            $pdf->Cell($cellWidths[$key], 10, iconv('UTF-8', 'TIS-620', $col), 1, 0, 'C');
        }
        $pdf->Ln();

        $statusList = array("1" => "MOI", "2" => "MOU", "3" => "MOA");
        $statusList1 = array("1" => "ในประเทศ", "2" => "ต่างประเทศ");

        // เพิ่มข้อมูลลงในตาราง
        while ($row = $query->fetch_assoc()) {
            $pdf->SetX($startX); // ตั้งค่าตำแหน่งเริ่มต้นให้ตรงกลาง
            $pdf->Cell($cellWidths[0], 10, iconv('UTF-8', 'TIS-620', $i++), 1, 0, 'C');
            $pdf->Cell($cellWidths[1], 10, iconv('UTF-8', 'TIS-620', $row['nameMou']), 1, 0, 'C');
            $pdf->Cell($cellWidths[2], 10, iconv('UTF-8', 'TIS-620', $row['deptAciton']), 1, 0, 'C');
            $pdf->Cell($cellWidths[3], 10, iconv('UTF-8', 'TIS-620', $row['deptNameCo']), 1, 0, 'C');
            $pdf->Cell($cellWidths[4], 10, iconv('UTF-8', 'TIS-620', $statusList1[$row['department']]), 1, 0, 'C');
            $pdf->Cell($cellWidths[5], 10, iconv('UTF-8', 'TIS-620', '' . $row['time_mou'] . ' ปี'), 1, 0, 'C');
            $pdf->Cell($cellWidths[6], 10, iconv('UTF-8', 'TIS-620', DateThai($row['dateStart'])), 1, 0, 'C');
            $pdf->Cell($cellWidths[7], 10, iconv('UTF-8', 'TIS-620', DateThai($row['dateExpired'])), 1, 0, 'C');
            $pdf->Ln();
        }
    }else {
        $pdf->SetFont('THSarabunNew', '', 16);
        $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ไม่มีข้อมูลที่ตรงตามเงื่อนไขที่เลือก'), 0, 1, 'C');
    }
}

//ส่งออก
$pdf->Output();
?>