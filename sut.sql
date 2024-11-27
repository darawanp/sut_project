-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2024 at 04:58 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sut`
--

-- --------------------------------------------------------

--
-- Table structure for table `about`
--

CREATE TABLE `about` (
  `about_no` int(11) NOT NULL COMMENT 'เลขที่เกี่ยวกับ',
  `about_title` varchar(255) NOT NULL COMMENT 'หัวข้อเกี่ยวกับ',
  `about_details` varchar(5000) NOT NULL COMMENT 'รายละเอียดเกี่ยวกับ',
  `about_img` varchar(255) NOT NULL COMMENT 'รูปภาพเกี่ยวกับ',
  `about_type` varchar(255) NOT NULL COMMENT 'ประเภทเกี่ยวกับ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `about`
--

INSERT INTO `about` (`about_no`, `about_title`, `about_details`, `about_img`, `about_type`) VALUES
(1, 'ประวัติงานวิเทศสัมพันธ์', '<p style=\"text-align: left;\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;มหาวิทยาลัยเทคโนโลยีราชมงคลอีสานเป็นหนึ่งในมหาวิทยาลัยที่ได้รับการสถาปนาภายใต้พระราชบัญญัติมหาวิทยาลัยเทคโนโลยีราชมงคล พ.ศ. 2548 เมื่อวันที่ 18 มกราคม พ.ศ. 2548 โดยมีฐานะเป็นนิติบุคคลและส่วนราชการในสังกัดสำนักงานคณะกรรมการการอุดมศึกษา กระทรวงศึกษาธิการ\r\n</p><p style=\"text-align: left;\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;ภายในมหาวิทยาลัยฯ กองนโยบายและแผนเป็นหน่วยงานระดับกอง ซึ่งสังกัดสำนักงานอธิการบดี โดยกองนี้ถูกจัดตั้งขึ้นตามอำนาจที่ได้รับจากพระราชบัญญัติมหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน พ.ศ. 2548 มาตรา 6 และมาตรา 9 วรรคสอง เพื่อทำหน้าที่วางแผน กำหนดทิศทางการพัฒนามหาวิทยาลัยในอนาคต ทำหน้าที่วิเคราะห์แผนงานงบประมาณ เก็บรวบรวมข้อมูล พัฒนาระบบสารสนเทศเพื่อการบริหาร และดำเนินการด้านวิเทศสัมพันธ์\r\n</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; กองนโยบายและแผนประกอบด้วย 5 งาน 2 ศูนย์ และ 1 สถาบัน ได้แก่\r\n</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; • งานบริหารงานทั่วไป\r\n</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; • งานนโยบายและแผนยุทธศาสตร์\r\n</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; • งานงบประมาณและติดตามประเมินผล\r\n</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; • งานข้อมูลสารสนเทศ\r\n</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; • งานวิเทศสัมพันธ์\r\n</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; • ศูนย์ศึกษานานาชาติ\r\n</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; • ศูนย์วิจัยและพัฒนาบึงกาฬ\r\n</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; • สถาบันวิจัยและพัฒนามุกดาหาร\r\n</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; อาศัยอำนาจตามความในมาตรา 8 มาตรา 9 วรรคท้ายและมาตรา 17 (2) แห่งพระราชบัญญัติมหาวิทยาลัยเทคโนโลยีราชมงคล\r\n</p><p style=\"text-align: left;\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; งานวิเทศสัมพันธ์ ซึ่งเป็นหนึ่งในหน่วยงานภายใต้กองนโยบายและแผน มีหน้าที่สนับสนุนนโยบายของมหาวิทยาลัยในการสร้างเครือข่ายความร่วมมือทั้งในประเทศและต่างประเทศ เพื่อประชาสัมพันธ์มหาวิทยาลัย ส่งเสริมชื่อเสียงให้เป็นที่รู้จักในระดับสากล และขับเคลื่อนแผนยุทธศาสตร์ของมหาวิทยาลัยเพื่อการพัฒนาที่มีประสิทธิภาพและยั่งยืน.\r\n</p>', '', 'ประวัติ'),
(2, 'พันธกิจ', '<p style=\"text-align: left;\">1. ร่วมกำหนดและดำเนินงานยุทธศาสตร์ด้านต่างประเทศของมหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน\r\n</p><p style=\"text-align: left;\">2. สร้างและแสวงหาเครือข่ายความร่วมมือกับหน่วยงานภาครัฐและภาคเอกชนทั้งในและต่างประเทศ\r\n</p><p style=\"text-align: left;\">3. ทำนุบำรุงและเผยแพร่ ภาษา ศิลปะ และวัฒนธรรมไทยให้เป็นที่รู้จักในต่างประเทศ\r\n</p><p style=\"text-align: left;\">4. ประชาสัมพันธ์ เผยแพร่ผลงานของมหาวิทยาลัยในระดับนานาชาติ\r\n</p>', '', 'พันธกิจ'),
(3, 'ภารกิจหลัก', '<p>1. ติดต่อประสานงานและสร้างเครือข่ายความร่วมมือระหว่างมหาวิทยาลัยเทคโนโลยีราชมงคลอีสานกับสถาบันการศึกษาหรือหน่วยงานทั้งภาครัฐและภาคเอกชนทั้งในและต่างประเทศ\r\n</p><p>2. ประชาสัมพันธ์และเผยแพร่กิจกรรมของมหาวิทยาลัยฯ ให้แก่สถาบันการศึกษาหรือหน่วยงานต่างๆ ทั้งในและต่างประเทศ\r\n</p><p>3. ให้ข้อเสนอแนะ ข้อแนะนำ และเอื้ออำนวยความสะดวกให้แก่นักศึกษาและบุคลากรชาวต่างประเทศที่ปฏิบัติงานในมหาวิทยาลัยฯ\r\n</p><p>4. กำกับ ดูแล ตรวจสอบ และเสนอทุนของมหาวิทยาลัยฯ ให้แก่นักศึกษา อาจารย์ นักวิชาการ และนักวิจัย จากต่างประเทศเพื่อมาศึกษาและปฏิบัติงานในมหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน\r\n</p><p>5. เป็นศูนย์กลางในการให้ข้อมูลข่าวสาร ข้อเสนอแนะและอำนวยความสะดวกทางด้านการต่างประเทศแก่บุคลากรของมหาวิทยาลัยฯ\r\n</p>', '', 'ภารกิจหลัก'),
(4, 'รศ.ดร.โฆษิต ศรีภูธร', 'อธิการบดีมหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน', 'Leader1.png', 'บุคลากร'),
(5, 'รศ.ดร.ณรงค์ศักดิ์  ธรรมโชติ', 'รองอธิการบดีฝ่ายวิชาการและวิเทศสัมพันธ์', 'ViceChancellor.png', 'บุคลากร'),
(6, 'ผศ.ดร.ระบิล พ้นภัย', 'ผู้ช่วยอธิการบดีด้านวิเทศสัมพันธ์ กิจการนักศึกษาและบุคลากรสู่ความเป็นเลิศสู่สากล', 'AssistantRector.jpg', 'บุคลากร'),
(7, 'นางสาวปณิธาน ประสานจิตต์', 'หัวหน้างานวิเทศสัมพันธ์', 'manager.png', 'บุคลากร'),
(8, 'นางสาวอารีย์รัตน์ หมั่นทองหลาง', 'นักวิเทศสัมพันธ์', 'InternationalAffairsOfficer1.png', 'บุคลากร'),
(9, 'นางสาวจตุรพร จ่างโพธิ์', 'นักวิเทศสัมพันธ์', 'InternationalAffairsOfficer2.png', 'บุคลากร');

-- --------------------------------------------------------

--
-- Table structure for table `agency_university`
--

CREATE TABLE `agency_university` (
  `ag_id` int(11) NOT NULL COMMENT 'รหัสฝ่ายงาน',
  `agencyname_thai` varchar(100) NOT NULL COMMENT 'ชื่อฝ่ายงาน'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `agency_university`
--

INSERT INTO `agency_university` (`ag_id`, `agencyname_thai`) VALUES
(1, 'ฝ่ายบริหารงานทั่วไป'),
(2, 'ฝ่ายวิจัยและพัฒนาสื่อการศึกษา'),
(3, 'ฝ่ายผลิตสื่อคอมพิวเตอร์'),
(4, 'ฝ่ายผลิตสื่อโสตทัศน์'),
(5, 'ฝ่ายเทคนิควิศวกรรม'),
(6, 'สำนักพิมพ์'),
(7, 'ฝ่ายพัฒนานวัตกรรม');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `contact_no` int(11) NOT NULL COMMENT 'เลขที่ติดต่อ',
  `contact_address` varchar(255) NOT NULL COMMENT 'ที่อยู่ : หน่วยงาน',
  `contact_university` varchar(500) NOT NULL COMMENT 'ที่อยู่ : ศูนย์นวัตรกรรม',
  `contact_tel` varchar(20) NOT NULL COMMENT 'เบอร์โทรศัพท์',
  `contact_email` varchar(255) NOT NULL COMMENT 'อีเมล'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`contact_no`, `contact_address`, `contact_university`, `contact_tel`, `contact_email`) VALUES
(1, 'อาคาร 19 อาคารสำนักงานอธิการบดี\r\nชั้น 4 งานวิเทศสัมพันธ์', '744 ถนนสุรนารายณ์ ตำบลในเมือง อำเภอเมืองนครราชสีมา \r\nจังหวัดนครราชสีมา 30000', '044-233-000 ต่อ 2451', 'iro@rmuti.ac.th');

-- --------------------------------------------------------

--
-- Table structure for table `doc_category`
--

CREATE TABLE `doc_category` (
  `doc_cate_no` int(11) NOT NULL COMMENT 'เลขหมวดหมู่',
  `doc_cate_name` varchar(255) NOT NULL COMMENT 'ชื่อหมวดหมู่'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `doc_category`
--

INSERT INTO `doc_category` (`doc_cate_no`, `doc_cate_name`) VALUES
(1, 'เอกสารประกอบการขอจัดทําบันทึกความร่วมมือทางวิชาการ(MOI/MOU/MOA) '),
(2, 'เอกสารประกอบการขอและต่ออายุ Visa และใบอนุญาตการทํางาน (Work permit)');

-- --------------------------------------------------------

--
-- Table structure for table `download`
--

CREATE TABLE `download` (
  `download_no` int(11) NOT NULL COMMENT 'เลขที่ดาวน์โหลด',
  `file_name` varchar(255) DEFAULT NULL COMMENT 'ชื่อเอกสาร',
  `doc_cate_no` int(11) DEFAULT NULL COMMENT 'เลขที่หมวดหมู่',
  `file_path` varchar(255) DEFAULT NULL COMMENT 'อัปโหลดเอกสาร',
  `file_type` varchar(255) DEFAULT NULL COMMENT 'ประเภทเอกสาร'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam_schedule`
--

CREATE TABLE `exam_schedule` (
  `exam_id` int(11) NOT NULL,
  `exam_date` date NOT NULL,
  `exam_time` varchar(20) NOT NULL,
  `num_proctors` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `exam_type_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `exam_schedule`
--

INSERT INTO `exam_schedule` (`exam_id`, `exam_date`, `exam_time`, `num_proctors`, `created_at`, `updated_at`, `exam_type_id`) VALUES
(36, '2024-11-21', '9:00-12:00', 3, '2024-11-21 06:22:41', '2024-11-21 06:22:47', 1),
(37, '2024-11-22', '16:00-19:30', 5, '2024-11-21 06:23:01', '2024-11-21 06:23:07', 2),
(39, '2024-11-26', '13:00-16:00', 5, '2024-11-21 06:38:49', '2024-11-21 06:38:49', 1),
(40, '2024-11-21', '13:00-16:00', 5, '2024-11-21 06:39:36', '2024-11-21 06:39:36', 2),
(41, '2024-11-23', '13:00-16:00', 5, '2024-11-21 06:45:47', '2024-11-21 06:45:47', 1);

-- --------------------------------------------------------

--
-- Table structure for table `exam_types`
--

CREATE TABLE `exam_types` (
  `exam_type_id` int(11) NOT NULL,
  `exam_types_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `exam_types`
--

INSERT INTO `exam_types` (`exam_type_id`, `exam_types_name`) VALUES
(1, 'สอบกลางภาค'),
(2, 'สอบประจำภาค');

-- --------------------------------------------------------

--
-- Table structure for table `goal`
--

CREATE TABLE `goal` (
  `goal_id` int(11) NOT NULL COMMENT 'รหัสเป้าหมาย',
  `goal_detail` varchar(10000) NOT NULL COMMENT 'รายละเอียดของเป้าหมาย',
  `goalty_id` int(11) NOT NULL COMMENT 'ไอดีหมวดเป้าประสงค์'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `goal`
--

INSERT INTO `goal` (`goal_id`, `goal_detail`, `goalty_id`) VALUES
(1, 'การสร้างและพัฒนาศักยภาพผู้เรียนที่เน้นการเรียนการสอนควบคู่กับการปฏิบัติการจริงเพื่อพัฒนาสมรรถนะและทักษะระดับสูงในการทํางาน มีความรู้และความเชี่ยวชาญด้านเทคโนโลยีให้สามารถนําองค์ความรู้ไปประยุกต์เพื่อสร้างนวัตกรรม พัฒนาผลิตภัณฑ์ และบริการสังคม', 1),
(2, 'การสร้างนวัตกรรมจากงานวิจัย เพื่อนําไปใช้ในเชิงพาณิชย์หรือสาธารณประโยชน์ เพื่อสร้างมูลค่าเพิ่มตลอดห่วงโซ่มูลค่าในภาคอุตสาหกรรมการผลิต การค้า และการบริการ', 1),
(3, 'การส่งเสริมบทบาทความร่วมมือ กับ ภาครัฐ และ ภาคเอกชน ทั้งในประเทศและต่างประเทศเพื่อสนับสนุนและพัฒนาเทคโนโลยีและนวัตกรรม', 1),
(4, 'การสนองโครงการอันเนื่องมาจากพระราชดําริ และทํานุบํารุงศิลปวัฒนธรรม เพื่อพัฒนาท้องถิ่นสังคม สู่ความยั่งยืน', 1),
(5, 'ประเด็นยุทธศาสตร์ ที่ 1 : พลิกโฉมการสอน สร้างนักปฏิบัติ นวัตกรรมและการเป็นผู้ประกอบการ', 2),
(6, 'ประเด็นยุทธศาสตร์ ที่ 2 : ยกระดับการทํางานวิจัย สร้างเทคโนโลยีและนวัตกรรมสู่เชิงพาณิชย์', 2),
(7, 'ประเด็นยุทธศาสตร์ ที่ 3 : บูรณาการความร่วมมือกับพหุภาคี ทั้งในประเทศและต่างประเทศ', 2),
(8, 'ประเด็นยุทธศาสตร์ ที่ 4 : เปลี่ยนผ่านระบบการบริหารองค์กรสู่ยุคดิจิทัล และเชื่อมโยงสู่การพัฒนาที่ยั่งยืน', 2),
(9, 'Cluster ที่ 1) Logistics ประกอบด้วย ระบบราง (Rail System), อากาศยาน (Aviation), โลจิสติกส์ (Logistics), ยานยนต์ไฟฟ้า/ พลังงานที่ยั่งยืน (Electric Vehicle, EV /Sustainable Energy, SE) และ หุ่นยนต์/ระบบ\r\nอัตโนมัติ/เอไอ (Robotics/Automation/AI)', 3),
(10, 'Cluster ที่ 2) Agriculture Technology & Food Security ประกอบด้วย การเปลี่ยนแปลงสภาพภูมิอากาศ (Climate Change (Carbon Neutrality, Net Zero GHG Emission)) , วิกฤตทางอาหาร (Food Crisis (Organic Food, Functional Food, Future Food)) และ เกษตรสมัยใหม่ (Agriculture (Organic, Smart Farm,Offseason, Water Management))', 3),
(11, 'Cluster ที่ 3) Health & Tourism ประกอบด้วย สุขภาพแบบองค์รวม (Wellness (Herbal Product, Cosmetic Spa, Alternative Medicine for Aging Society, Medical Tools)) และ การท่องเที่ยว (Tourism)', 3);

-- --------------------------------------------------------

--
-- Table structure for table `goal_type`
--

CREATE TABLE `goal_type` (
  `goalty_id` int(11) NOT NULL COMMENT 'ไอดีหมวดเป้าประสงค์',
  `goalty_title` varchar(10000) NOT NULL COMMENT 'ชื่อหมวดเป้าประสงค์'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `goal_type`
--

INSERT INTO `goal_type` (`goalty_id`, `goalty_title`) VALUES
(1, 'สอดคล้องกับตามพันธกิจ'),
(2, 'สอดคล้องกับประเด็นยุทธศาสตร์'),
(3, 'สอดคล้องกับจุดเน้น (Cluster)');

-- --------------------------------------------------------

--
-- Table structure for table `mou`
--

CREATE TABLE `mou` (
  `mouid` int(11) NOT NULL COMMENT 'รหัสMOU',
  `dates_tr` date NOT NULL,
  `deptNameCo` varchar(250) NOT NULL COMMENT 'ชื่อหน่วยงานที่มีความร่วมมือ',
  `Mo_type` varchar(1) NOT NULL COMMENT 'ประเภทความร่วมมือ{\r\n1:MOI, 2:MOU, 3:MOA}',
  `department` varchar(1) NOT NULL COMMENT 'หนาวยงาน/สถาบัน{\r\n1:ภายในประเทศ, 2:ต่างประเทศ}',
  `deptType` int(11) NOT NULL COMMENT 'ประเภทหน่วยงาน',
  `depAddress` varchar(255) NOT NULL COMMENT 'ที่อยู่ของหน่วยงานที่ร่วมมือ',
  `time_mou` varchar(255) NOT NULL COMMENT 'ระยะเวลาของบันทึกความร่วมมือ',
  `CountyName` varchar(250) NOT NULL COMMENT 'ชื่อประเทศ',
  `nameMou` varchar(250) NOT NULL COMMENT 'ชื่อบันทึกความร่วมมือทางวิชาการ',
  `dateStart` date NOT NULL COMMENT 'วัน/เดือน/ปี ที่ลงนาม',
  `dateExpired` date NOT NULL COMMENT 'วัน/เดือน/ปี หมดอายุ',
  `deptAciton` varchar(250) NOT NULL COMMENT 'ชื่อหน่วยงานที่ดำเนินการ',
  `signRmuti` varchar(250) NOT NULL COMMENT 'ชื่อผู้ลงนาม (ฝ่าย มทร.)',
  `signRmutiWitness` varchar(250) NOT NULL COMMENT 'ชื่อพยาน (ฝ่าย มทร.)',
  `signCo` varchar(250) NOT NULL COMMENT 'ชื่อผู้ลงนาม (ฝ่ายพันธมิตร)',
  `signCoWitness` varchar(250) NOT NULL COMMENT 'ชื่อพยาน (ฝ่ายพันธมิตร)',
  `objDesc` varchar(2000) NOT NULL COMMENT 'วัตถุประสงค์ของความร่วมมือ',
  `activityDesc` varchar(2000) NOT NULL COMMENT 'กิจกรรมที่เกิดจากความร่วมมือ',
  `userDesc` varchar(250) NOT NULL COMMENT 'ผู้ให้ข้อมูล{ชื่อ, สังกัด, ช่องทางการติดต่อ}',
  `date_log` datetime NOT NULL,
  `IsActive` varchar(250) NOT NULL COMMENT 'สถานะการทำงาน{Active, Inactive}',
  `renewal` varchar(1) NOT NULL COMMENT 'เงื่อนไขการต่ออายุ{\r\n1: , 2: , 3: , 4: }',
  `renewaltime` varchar(10) NOT NULL COMMENT 'จำนวนอายุต่ออัตโนมัติ',
  `ag_id` int(11) NOT NULL COMMENT 'รหัสหน่วยงานภายในมหาลัย',
  `file_path` varchar(500) NOT NULL COMMENT 'PDF File',
  `gg_drive` varchar(1000) NOT NULL COMMENT 'ลิงค์ google drive',
  `goal_id` varchar(100) NOT NULL COMMENT 'รหัสเป้าประสงค์การลงนาม'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `mou`
--

INSERT INTO `mou` (`mouid`, `dates_tr`, `deptNameCo`, `Mo_type`, `department`, `deptType`, `depAddress`, `time_mou`, `CountyName`, `nameMou`, `dateStart`, `dateExpired`, `deptAciton`, `signRmuti`, `signRmutiWitness`, `signCo`, `signCoWitness`, `objDesc`, `activityDesc`, `userDesc`, `date_log`, `IsActive`, `renewal`, `renewaltime`, `ag_id`, `file_path`, `gg_drive`, `goal_id`) VALUES
(1, '2024-10-02', 'Project G.4', '2', '1', 1, 'คณะบริหารธุรกิจ', '1', '', 'test 1', '2024-10-02', '2024-10-03', 'คณะบริหารธุรกิจ', 'ธีรดา', 'ณัชกานต์', 'ธีรดา', 'ณัฐรดา', 'test system INSERT', '', 'ธีรดา,แอดมิน,-,-,-,-,-', '0000-00-00 00:00:00', '', '2', '', 2, '../document/mo_pdf/Ch05.pdf', 'https://drive.google.com/drive/u/0/folders/1a1FAmMrMm-a8CD8MT85N_HXZaTmwFtcq', '1,6,10'),
(2, '2024-10-06', 'Project G.4', '1', '1', 1, 'มทร.อีสาน', '1', '', 'เพิ่มข้อมูลแบบทุกส่วน', '2024-10-06', '2024-10-07', 'คณะบริหารธุรกิจ', 'ธีรดา', 'ณัชกานต์', 'ธีรดา', 'ณัฐรดา', 'test show data', '', 'ณัชกานต์ หุนตะคุ,สมาชิก,บริหารธุรกิจ,02345678954,0887956695,natchakan.hu@rmuti.ac.th,0236541785', '0000-00-00 00:00:00', '', '3', '2', 2, '../document/mo_pdf/IP-03.pdf', 'https://drive.google.com/drive/u/0/folders/1a1FAmMrMm-a8CD8MT85N_HXZaTmwFtcq', '1,10'),
(6, '2024-10-13', 'xxxxxx', '2', '1', 1, 'home', '1', '', 'ทดสอบเพิ่มใน admin', '2024-10-13', '2024-10-13', 'คณะบริหารธุรกิจ', '-', '-', '-', '-', 'test ', '', 'xxxx,xxxx,xxxxx,xxxx,xxxxx,xxxx,xxxxxx', '0000-00-00 00:00:00', '', '3', '', 2, 'IP-03.pdf', 'https://drive.google.com/drive/u/1/my-drive', '2,8,10');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `news_no` int(11) NOT NULL COMMENT 'เลขที่ข่าว',
  `news_title` varchar(255) NOT NULL COMMENT 'หัวข้อข่าว',
  `news_date` date NOT NULL COMMENT 'วัน/เดือน/ปี ที่ลงข่าว',
  `news_img` varchar(255) NOT NULL COMMENT 'รูปภาพข่าว',
  `viewership` int(10) NOT NULL COMMENT 'จำนวนผู้เข้าชม',
  `news_details` varchar(500) NOT NULL COMMENT 'รายละเอียดข่าว',
  `news_type` varchar(40) NOT NULL COMMENT 'ประเภทข่าว{1:ประชาสัมพันธ์, 2:กิจกรรม}',
  `news_gallery` text NOT NULL COMMENT 'เก็บรูปได้หลายรูป'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`news_no`, `news_title`, `news_date`, `news_img`, `viewership`, `news_details`, `news_type`, `news_gallery`) VALUES
(26, 'มทร.อีสาน ร่วม กรมสนับสนุนบริการสุขภาพ ลงนามความร่วมมือการส่งเสริมและพัฒนายุวอาสาสมัครสาธารณสุข มุ่งพัฒนาด้านทักษะการจัดกิจกรรมการเรียนรู้ด้านสุขภาพ และทักษะชีวิตที่จำเป็นแก่ยุวอาสาสมัครสาธารณสุข', '2024-10-16', 'ปก-30.jpg', 0, '<p>วันพุธที่ 25 กันยายน 2567&nbsp;มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน โดย รองศาสตราจารย์ ดร.โฆษิต ศรีภูธร อธิการบดี มทร.อีสาน พร้อมคณะผู้บริหารมหาวิทยาลัย เข้าร่วมพิธีลงนามบันทึกข้อตกลงความร่วมมือการส่งเสริมและพัฒนายุวอาสาสมัครสาธารณสุข ร่วมกับกรมสนับสนุนบริการสุขภาพ นำโดย นายแพทย์สุระ วิเศษศักดิ์ อธิบดีกรมสนับสนุนบริการสุขภาพ ณ ห้องประชุมสุขศึกษา ชั้น 9 กรมสนับสนุนบริการสุขภาพ จ.นนทบุรี<br></p>', '1', 'LINE_ALBUM_MOU-สาธารณสุข_240925_3-jpg.jpg,LINE_ALBUM_MOU-สาธารณสุข_240925_4-jpg.jpg,LINE_ALBUM_MOU-สาธารณสุข_240925_6-jpg.jpg,LINE_ALBUM_MOU-สาธารณสุข_240925_7-jpg.jpg,LINE_ALBUM_MOU-สาธารณสุข_240925_14-1-jpg.jpg'),
(27, 'มทร.อีสาน เข้าร่วมพิธีลงนามความร่วมมือ ภายใต้ชื่อ ฮักนะ ลูกหลานย่าโม : ประกาศเจตนารมณ์ “การส่งเสริมความเสมอภาคและขจัดการเลือกปฏิบัติโดยไม่เป็นธรรมระหว่างเพศ จังหวัดนครราชสีมา', '2024-10-16', 'ปก-25.jpg', 0, '<p>วันพุธที่ 25 กันยายน 2567&nbsp;มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน โดย รองศาสตราจารย์ ดร.โฆษิต ศรีภูธร อธิการบดี มทร.อีสาน พร้อมคณะผู้บริหารมหาวิทยาลัย เข้าร่วมพิธีลงนามบันทึกข้อตกลงความร่วมมือการส่งเสริมและพัฒนายุวอาสาสมัครสาธารณสุข ร่วมกับกรมสนับสนุนบริการสุขภาพ นำโดย นายแพทย์สุระ วิเศษศักดิ์ อธิบดีกรมสนับสนุนบริการสุขภาพ ณ ห้องประชุมสุขศึกษา ชั้น 9 กรมสนับสนุนบริการสุขภาพ จ.นนทบุรี<br></p>', '2', 'S__3416082_0-jpg.jpg,S__3416084_0-1536x864.jpg,S__3416085_0-jpg.jpg,S__3416088_0-jpg.jpg,S__3416089_0-jpg.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `picture`
--

CREATE TABLE `picture` (
  `picture_no` int(11) NOT NULL COMMENT 'เลขที่รูปภาพแสดงหน้าIndex',
  `picture_file` varchar(500) NOT NULL COMMENT 'เก็บพาธรูป'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `picture`
--

INSERT INTO `picture` (`picture_no`, `picture_file`) VALUES
(1, 'silde1.png'),
(2, 'images (2).png');

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `service_no` int(11) NOT NULL COMMENT 'เลขที่บริการ',
  `service_title` varchar(1000) NOT NULL COMMENT 'หัวข้อบริการ',
  `service_details` varchar(10000) NOT NULL COMMENT 'รายละเอียดบริการ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`service_no`, `service_title`, `service_details`) VALUES
(1, 'การขอและต่ออายุ Visa และใบอนุญาตการทำงาน (Work permit)', '<p>การขอและต่ออายุ Visa และใบอนุญาตการทำงาน (Work permit)<br></p>'),
(2, 'ทุนต่างประเทศ', '<p>ทุนต่างประเทศ<br></p>'),
(3, 'เพิ่มบริการ2', '<p>เพิ่มบริการ 2</p>');

-- --------------------------------------------------------

--
-- Table structure for table `type_activity`
--

CREATE TABLE `type_activity` (
  `typeAct_no` int(11) NOT NULL COMMENT 'รหัสประเภทกิจกรรม',
  `typeAct_name` varchar(100) NOT NULL COMMENT 'ชื่อประเภทกิจกรรม'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `type_activity`
--

INSERT INTO `type_activity` (`typeAct_no`, `typeAct_name`) VALUES
(1, 'เข้าร่วมประชุม /สัมมนา'),
(2, 'เข้าร่วมฝึกอบรม/ ฝึกปฏิบัติการ'),
(3, 'ทุนการศึกษา'),
(4, 'ทําการสอนร่วม'),
(5, 'ปฏิบัติงานวิจัย'),
(6, 'ปฏิบัติงานสหกิจศึกษา'),
(7, 'ประชาสัมพันธ์หลักสูตร'),
(8, 'ร่วมพัฒนาหลักสูตร'),
(9, 'รับรองอาคันตุกะ'),
(10, 'แลกเปลี่ยนนักศึกษา'),
(11, 'แลกเปลี่ยนบุคลากร'),
(12, 'วิทยากรบรรยาย'),
(13, 'ศึกษาดูงาน'),
(14, 'อื่นๆ โปรดระบุ...');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL COMMENT 'รหัสพนักงาน',
  `username` varchar(50) NOT NULL COMMENT 'ชื่อผู้ใช้',
  `password` varchar(30) NOT NULL COMMENT 'รหัสผ่าน',
  `name` varchar(50) NOT NULL COMMENT 'ชื่อ',
  `lastname` varchar(50) NOT NULL COMMENT 'นามสกุล',
  `email` varchar(35) NOT NULL COMMENT 'อีเมล',
  `phone` char(15) NOT NULL COMMENT 'เบอร์โทรศัพท์',
  `tel` char(15) NOT NULL COMMENT 'เบอร์ภายใน',
  `user_type` int(1) NOT NULL COMMENT 'ประเภทผู้ใช้{1:ผู้ดูแลระบบ, 2:ผู้ใช้งานระบบ,}',
  `status` int(11) NOT NULL COMMENT 'สถานะผู้เข้าใช้งาน{0:ไม่อนุญาตให้เข้าใช้งาน, 1:อนุญาตให้เข้าใช้งาน',
  `ag_id` int(11) NOT NULL COMMENT 'รหัสหน่วยงาน'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `name`, `lastname`, `email`, `phone`, `tel`, `user_type`, `status`, `ag_id`) VALUES
(5, 'admin', '1234', 'admin', '1234', '', '', '', 1, 1, 1),
(7, '1234', '1234', '1234', '1234', '', '', '', 1, 1, 0),
(12, 'ice', '1234', 'ดาราวรรณ', 'พรมลักษ์', '', '081-112', '-', 1, 1, 6),
(13, 'pad123', '1234', 'พัชรี', 'ศรีอ่อนหล้า', '', '', '', 1, 1, 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`about_no`);

--
-- Indexes for table `agency_university`
--
ALTER TABLE `agency_university`
  ADD PRIMARY KEY (`ag_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`contact_no`);

--
-- Indexes for table `doc_category`
--
ALTER TABLE `doc_category`
  ADD PRIMARY KEY (`doc_cate_no`);

--
-- Indexes for table `download`
--
ALTER TABLE `download`
  ADD PRIMARY KEY (`download_no`),
  ADD KEY `doc_` (`doc_cate_no`);

--
-- Indexes for table `exam_schedule`
--
ALTER TABLE `exam_schedule`
  ADD PRIMARY KEY (`exam_id`),
  ADD KEY `exam_type_id` (`exam_type_id`);

--
-- Indexes for table `exam_types`
--
ALTER TABLE `exam_types`
  ADD PRIMARY KEY (`exam_type_id`);

--
-- Indexes for table `goal`
--
ALTER TABLE `goal`
  ADD PRIMARY KEY (`goal_id`),
  ADD KEY `goal_type` (`goalty_id`);

--
-- Indexes for table `goal_type`
--
ALTER TABLE `goal_type`
  ADD PRIMARY KEY (`goalty_id`);

--
-- Indexes for table `mou`
--
ALTER TABLE `mou`
  ADD PRIMARY KEY (`mouid`),
  ADD KEY `ag_id` (`ag_id`),
  ADD KEY `goal_id` (`goal_id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`news_no`);

--
-- Indexes for table `picture`
--
ALTER TABLE `picture`
  ADD PRIMARY KEY (`picture_no`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`service_no`);

--
-- Indexes for table `type_activity`
--
ALTER TABLE `type_activity`
  ADD PRIMARY KEY (`typeAct_no`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `agency_university` (`ag_id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about`
--
ALTER TABLE `about`
  MODIFY `about_no` int(11) NOT NULL AUTO_INCREMENT COMMENT 'เลขที่เกี่ยวกับ', AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `agency_university`
--
ALTER TABLE `agency_university`
  MODIFY `ag_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสฝ่ายงาน', AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `contact_no` int(11) NOT NULL AUTO_INCREMENT COMMENT 'เลขที่ติดต่อ', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `doc_category`
--
ALTER TABLE `doc_category`
  MODIFY `doc_cate_no` int(11) NOT NULL AUTO_INCREMENT COMMENT 'เลขหมวดหมู่', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `download`
--
ALTER TABLE `download`
  MODIFY `download_no` int(11) NOT NULL AUTO_INCREMENT COMMENT 'เลขที่ดาวน์โหลด', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `exam_schedule`
--
ALTER TABLE `exam_schedule`
  MODIFY `exam_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `exam_types`
--
ALTER TABLE `exam_types`
  MODIFY `exam_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `goal`
--
ALTER TABLE `goal`
  MODIFY `goal_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสเป้าหมาย', AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `goal_type`
--
ALTER TABLE `goal_type`
  MODIFY `goalty_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ไอดีหมวดเป้าประสงค์', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mou`
--
ALTER TABLE `mou`
  MODIFY `mouid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสMOU', AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `news_no` int(11) NOT NULL AUTO_INCREMENT COMMENT 'เลขที่ข่าว', AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `picture`
--
ALTER TABLE `picture`
  MODIFY `picture_no` int(11) NOT NULL AUTO_INCREMENT COMMENT 'เลขที่รูปภาพแสดงหน้าIndex', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `service_no` int(11) NOT NULL AUTO_INCREMENT COMMENT 'เลขที่บริการ', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `type_activity`
--
ALTER TABLE `type_activity`
  MODIFY `typeAct_no` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสประเภทกิจกรรม', AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสพนักงาน', AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `download`
--
ALTER TABLE `download`
  ADD CONSTRAINT `download_ibfk_1` FOREIGN KEY (`doc_cate_no`) REFERENCES `doc_category` (`doc_cate_no`);

--
-- Constraints for table `exam_schedule`
--
ALTER TABLE `exam_schedule`
  ADD CONSTRAINT `exam_schedule_ibfk_1` FOREIGN KEY (`exam_type_id`) REFERENCES `exam_types` (`exam_type_id`);

--
-- Constraints for table `goal`
--
ALTER TABLE `goal`
  ADD CONSTRAINT `goal_ibfk_1` FOREIGN KEY (`goalty_id`) REFERENCES `goal_type` (`goalty_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
