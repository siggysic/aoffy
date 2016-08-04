-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 04, 2016 at 05:18 AM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `manage_exam`
--

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_id` int(11) NOT NULL COMMENT 'รหัสข้อมูล',
  `code` varchar(5) NOT NULL COMMENT 'ชื่อย่อภาควิชา',
  `name` varchar(100) NOT NULL COMMENT 'ชื่อคณะ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `code`, `name`) VALUES
(1, 'TCT', 'เทคโนโลยีคอมพิวเตอร์'),
(3, 'TM', 'วิศวกรรมเครื่องกล'),
(4, 'TT', 'วิศวกรรมแมคคาทรอนิกส์ '),
(5, 'TP', 'วิศวกรรมการผลิตและอุตสาหการ');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `login_id` int(11) NOT NULL COMMENT 'รหัสของชื่อผู้ใช้',
  `username` varchar(50) NOT NULL COMMENT 'ชื่อผู้ใช้',
  `password` varchar(255) NOT NULL COMMENT 'รหัสผ่าน'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`login_id`, `username`, `password`) VALUES
(1, 'admin', '887375DAEC62A9F02D32A63C9E14C7641A9A8A42E4FA8F6590EB928D9744B57BB5057A1D227E4D40EF911AC030590BBCE2BFDB78103FF0B79094CEE8425601F5');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_id` int(11) NOT NULL COMMENT 'รหัสข้อมูลห้อง',
  `room_number` varchar(5) NOT NULL COMMENT 'เลขห้อง',
  `floor` varchar(2) DEFAULT NULL COMMENT 'ชั้น',
  `build` varchar(5) DEFAULT NULL COMMENT 'ตึก',
  `seat` int(5) NOT NULL COMMENT 'จำนวนที่นั่งสอบ',
  `remain` int(5) NOT NULL COMMENT 'ที่นั่งเหลือ',
  `status` set('ปกติ','ว่าง','เต็ม','ปิดใช้งาน') NOT NULL DEFAULT 'ปกติ' COMMENT 'สถานะ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='รายละเอียดห้องสอบ';

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_id`, `room_number`, `floor`, `build`, `seat`, `remain`, `status`) VALUES
(1, '205', '2', '52', 26, 23, 'ว่าง'),
(3, '301', '3', '52', 27, 27, 'ว่าง'),
(4, '304', '3', '52', 30, 30, 'ว่าง'),
(5, '612', '6', '52', 28, 28, 'ว่าง'),
(6, '302', '3', '52', 26, 26, 'ว่าง'),
(7, '404', '4', '52', 29, 0, 'ปกติ'),
(19, '304', '3', '52', 25, 0, 'ปกติ'),
(24, '203', '2', '52', 26, 0, 'ปกติ'),
(25, '201', '2', '52', 29, 0, 'ปกติ');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL COMMENT 'รหัสข้อมูล',
  `fname` varchar(100) NOT NULL COMMENT 'ชื่อ',
  `lname` varchar(100) NOT NULL COMMENT 'นามสกุล',
  `student_number` varchar(15) NOT NULL COMMENT 'รหัสนักศึกษา',
  `department_code` varchar(5) NOT NULL COMMENT 'รหัสภาควิชา',
  `subject_number` varchar(15) NOT NULL COMMENT 'รหัสวิชา',
  `section` int(5) NOT NULL COMMENT 'ตอนเรียน',
  `term` int(1) NOT NULL COMMENT 'ภาคการเรียน',
  `year` int(5) NOT NULL COMMENT 'ปีการศึกษา',
  `tel` varchar(15) DEFAULT NULL COMMENT 'หมายเลขโทรศัพท์',
  `email` varchar(100) DEFAULT NULL COMMENT 'อีเมล'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='ข้อมูลนักศึกษา';

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `fname`, `lname`, `student_number`, `department_code`, `subject_number`, `section`, `term`, `year`, `tel`, `email`) VALUES
(1, 'สันติภาพ', 'พวงจันทร์', '5402011610092', 'TM', '020123270', 1, 1, 2558, NULL, NULL),
(2, 'ไตรภพ', 'แสวงจิตร', '5502011620089', 'TM', '020123270', 1, 1, 2558, NULL, NULL),
(3, 'ชัชพล', 'วังบุญ', '5502011630068', 'TM', '020123270', 1, 1, 2558, NULL, NULL),
(4, 'ไชยมงคล', 'แซ่เอี๋ยว', '5602011610082', 'TM', '020123270', 1, 1, 2558, NULL, NULL),
(5, 'ตรีวิทย์', 'จันทรมณี', '5602011620070', 'TM', '020123270', 1, 1, 2558, NULL, NULL),
(6, 'ณัฐพล', 'สุขขีธรรม', '5602011620142', 'TM', '020123270', 1, 1, 2558, NULL, NULL),
(7, 'ชัชวาล', 'สกุลวาทิต', '5602011630024', 'TM', '020123270', 1, 1, 2558, NULL, NULL),
(8, 'คฑาวุธ', 'อินทพันธ์', '5702011610014', 'TM', '020123270', 1, 1, 2558, NULL, NULL),
(9, 'จิรศักดิ์', 'ศักดิ์ภิรมย์', '5702011610022', 'TM', '020123270', 1, 1, 2558, NULL, NULL),
(10, 'ณัฐวุฒิ', 'ทันประโยชน์', '5702011610057', 'TM', '020123270', 1, 1, 2558, NULL, NULL),
(11, 'วีรพงศ์', 'ปานาพุฒ', '5702011610090', 'TM', '020123270', 1, 1, 2558, NULL, NULL),
(12, 'ณัฐกานต์', 'สีสด', '5702011610154', 'TM', '020123270', 1, 1, 2558, NULL, NULL),
(13, 'สาธิน', 'อิ่มฤทัย', '5702011620133', 'TM', '020123270', 1, 1, 2558, NULL, NULL),
(14, 'อัฐพล', 'บุราณสุข', '5702011620206', 'TM', '020123270', 1, 1, 2558, NULL, NULL),
(15, 'กฤตภาส', 'สังข์วรรณะ', '5702011630015', 'TM', '020123270', 1, 1, 2558, NULL, NULL),
(16, 'กิตติศักดิ์', 'ลาโพธิ์', '5702011630023', 'TM', '020123270', 1, 1, 2558, NULL, NULL),
(17, 'ฤทธิชัย', 'มีโวหาร', '5702011630040', 'TM', '020123270', 1, 1, 2558, NULL, NULL),
(18, 'พงศธร', 'มาหา', '5702011630058', 'TM', '020123270', 1, 1, 2558, NULL, NULL),
(19, 'เกริกไกวัล', 'สืบเทพ', '5702011630104', 'TM', '020123270', 1, 1, 2558, NULL, NULL),
(43, 'วราภรณ์', 'ไกรจันดา', '5702041630001', 'TP', '030113260', 1, 1, 2558, NULL, NULL),
(44, 'นุชนารถ', 'ไชยช่วย', '5702041630002', 'TP', '030113260', 1, 1, 2558, NULL, NULL),
(45, 'เดโชชัย', 'บุญสม', '5702041630003', 'TP', '030113260', 1, 1, 2558, NULL, NULL),
(46, 'ธีรภัทร', 'ทองสุข', '5702041630004', 'TP', '030113260', 1, 1, 2558, NULL, NULL),
(47, 'พีชญา', 'สาละสุขา', '5702041630005', 'TP', '030113260', 1, 1, 2558, NULL, NULL),
(48, 'หนึ่งฤทัย', 'สีหา', '5702041630006', 'TP', '030113260', 1, 1, 2558, NULL, NULL),
(49, 'สิทธิราช', 'หว่างจิตร', '5702041630007', 'TP', '030113260', 1, 1, 2558, NULL, NULL),
(50, 'เจษฎา', 'สิงห์สุวรรณ', '5702041630008', 'TP', '030113260', 1, 1, 2558, NULL, NULL),
(51, 'อารีวรรณ', 'นาคนชม', '5702041630009', 'TP', '030113260', 1, 1, 2558, NULL, NULL),
(52, 'อารียา', 'นาคนชม', '5702041630010', 'TP', '030113260', 1, 1, 2558, NULL, NULL),
(53, 'บุญยวีร์', 'แสนพิลา', '5702041630011', 'TP', '030113260', 1, 1, 2558, NULL, NULL),
(54, 'ธิติวุฒิ', 'รักศิลป์', '5702041630012', 'TP', '030113260', 1, 1, 2558, NULL, NULL),
(55, 'ปภาวี', 'สีหะ', '5702041630013', 'TP', '030113260', 1, 1, 2558, NULL, NULL),
(56, 'โสธิดา', 'หงษ์สง่า', '5702041630014', 'TP', '030113260', 1, 1, 2558, NULL, NULL),
(57, 'สุชานาฏ', 'สุวรรณมาโจ', '5702041630015', 'TP', '030113260', 1, 1, 2558, NULL, NULL),
(58, 'ณัฐกิตติ์', 'พินิจนึก', '5702041630016', 'TP', '030113260', 1, 1, 2558, NULL, NULL),
(59, 'ณกรณ์', 'รุ่งแสงวีรพันธ์', '5702041630017', 'TP', '030113260', 1, 1, 2558, NULL, NULL),
(60, 'ญาณวิทย์', 'บัวคำ', '5702041630018', 'TP', '030113260', 1, 1, 2558, NULL, NULL),
(61, 'จันทรัตร์', 'อาศัย', '5702041630019', 'TP', '030113260', 1, 1, 2558, NULL, NULL),
(62, 'จันทร์จิรา', 'ประจงจัด', '5702041630020', 'TP', '030113260', 1, 1, 2558, NULL, NULL),
(63, 'วรากร', 'เตชะจารุวิทย์', '5702041630021', 'TP', '030113260', 1, 1, 2558, NULL, NULL),
(64, 'สิรภัทร', 'นามกิ่ง', '5702041630022', 'TP', '030113260', 1, 1, 2558, NULL, NULL),
(65, 'อุไรวรรณ', 'สิงหพัส', '5702041630023', 'TP', '030113260', 1, 1, 2558, NULL, NULL),
(66, 'รัชชานนท์', 'เฉลิมเผ่า', '5200870932001', 'TT', '020133112', 1, 1, 2558, NULL, NULL),
(67, 'สิริวิภา', 'เจริญผิว', '5200870932002', 'TT', '020133112', 1, 1, 2558, NULL, NULL),
(68, 'พิธิวัต ', 'เจริญขรรค์', '5200870932003', 'TT', '020133112', 1, 1, 2558, NULL, NULL),
(69, 'จักรพงศ์', 'อ่วมเจริญ', '5200870932004', 'TT', '020133112', 1, 1, 2558, NULL, NULL),
(70, 'นิรินธร', 'บุญสิน', '5200870932005', 'TT', '020133112', 1, 1, 2558, NULL, NULL),
(71, 'อาทิตย์', 'จิตเมตตา', '5200870932006', 'TT', '020133112', 1, 1, 2558, NULL, NULL),
(72, 'เสาวลักษณ์', 'ดวงจันทร์', '5200870932007', 'TT', '020133112', 1, 1, 2558, NULL, NULL),
(73, 'นพรัตน์', 'พรหมสนธิ', '5200870932008', 'TT', '020133112', 1, 1, 2558, NULL, NULL),
(74, 'สุชานันท์', 'โลหะวิทูร', '5200870932009', 'TT', '020133112', 1, 1, 2558, NULL, NULL),
(75, 'เพชร', 'เอื้ออามร', '5200870932010', 'TT', '020133112', 1, 1, 2558, NULL, NULL),
(76, 'ธัญนิชชา', 'แซ่เจี่ย', '5200870932011', 'TT', '020133112', 1, 1, 2558, NULL, NULL),
(77, 'กนกวรรณ', 'คุรุสวัสิด์', '5200870932012', 'TT', '020133112', 1, 1, 2558, NULL, NULL),
(78, 'ดารัตน์', 'มีศิลป์', '5200870932013', 'TT', '020133112', 1, 1, 2558, NULL, NULL),
(79, 'ภูวเดช', 'เขม็งกิจ', '5200870932014', 'TT', '020133112', 1, 1, 2558, NULL, NULL),
(80, 'ทิพากร ', 'ณ บางช้าง', '5200870932015', 'TT', '020133112', 1, 1, 2558, NULL, NULL),
(81, 'ชนัดดา', 'เจนทิวานนท์', '5200870932016', 'TT', '020133112', 1, 1, 2558, NULL, NULL),
(82, 'ภานุพงษ์', 'คำไพเราะ', '5200870932017', 'TT', '020133112', 1, 1, 2558, NULL, NULL),
(83, 'ธนิศา', 'ศิริเอก', '5200870932018', 'TT', '020133112', 1, 1, 2558, NULL, NULL),
(84, 'ภูมิพัฒน์', 'วรัทเกียรติธนา', '5200870932019', 'TT', '020133112', 1, 1, 2558, NULL, NULL),
(85, 'อรรัตน์', 'กันธิพร้าว', '5200870932020', 'TT', '020133112', 1, 1, 2558, NULL, NULL),
(86, 'ธีรวุฒิ', 'วางฐาน', '5200870932021', 'TT', '020133112', 1, 1, 2558, NULL, NULL),
(87, 'ณัฐวุฒิ', 'ชื่นโพธิ์กลาง', '5200870932022', 'TT', '020133112', 1, 1, 2558, NULL, NULL),
(88, 'สืบสกุล', 'ตุงคะเศวต', '5200870932023', 'TT', '020133112', 1, 1, 2558, NULL, NULL),
(89, 'นรภร', 'โกมลวิชญ์', '5200870932024', 'TT', '020133112', 1, 1, 2558, NULL, NULL),
(90, 'อารดา', 'ศรีสงค์', '5200870932025', 'TT', '020133112', 1, 1, 2558, NULL, NULL),
(91, 'สุรัชยา', 'สุทันต์', '5200870932026', 'TT', '020133112', 1, 1, 2558, NULL, NULL),
(92, 'จิรพงศ์', 'อัครวงษ์', '5200870932027', 'TT', '020133112', 1, 1, 2558, NULL, NULL),
(93, 'พนิตา', 'จั่นแก้ว', '5200870932028', 'TT', '020133112', 1, 1, 2558, NULL, NULL),
(94, 'ธนบูลย์', 'พุทธวงษ์', '5200870932029', 'TT', '020133112', 1, 1, 2558, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `subject_id` int(11) NOT NULL COMMENT 'รหัสข้อมูล',
  `subject_number` varchar(15) NOT NULL COMMENT 'รหัสวิชา',
  `name` varchar(100) NOT NULL,
  `start_time` time NOT NULL COMMENT 'เวลาเริ่มต้น',
  `end_time` time NOT NULL COMMENT 'เวลาสิ้นสุด',
  `day` date NOT NULL COMMENT 'วันที่สอบ',
  `section` int(5) NOT NULL COMMENT 'ตอนที่',
  `term` int(1) NOT NULL COMMENT 'เทอม',
  `year` int(5) NOT NULL COMMENT 'ปีการศึกษา',
  `hour` int(1) DEFAULT NULL COMMENT 'ชั่วโมง'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='ข้อมูลวิชาที่จัดสอบ';

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_id`, `subject_number`, `name`, `start_time`, `end_time`, `day`, `section`, `term`, `year`, `hour`) VALUES
(1, '020003203', 'Vocational Education Curriculum Development', '09:00:00', '12:00:00', '2015-12-11', 1, 1, 2558, NULL),
(2, '040203111', 'Engineering Mathematics I', '09:00:00', '12:00:00', '2015-11-30', 17, 1, 2558, NULL),
(3, '040203211', 'Engineering Mathematic III', '09:00:00', '12:00:00', '2015-11-30', 12, 1, 2558, NULL),
(4, '020113981', 'Engineering Drawing', '09:00:00', '12:00:00', '2015-11-30', 1, 1, 2558, NULL),
(5, '020133112', 'Hydraulics', '13:00:00', '16:00:00', '2015-11-30', 1, 1, 2558, NULL),
(6, '020113950', 'Pneumatics and Hydraulics', '13:00:00', '16:00:00', '2015-11-30', 1, 1, 2558, NULL),
(7, '030113260', 'Fundamental Drawing and Management', '13:00:00', '16:00:00', '2015-11-30', 1, 1, 2558, NULL),
(12, '030113260', 'Fundamental Drawing and Management', '13:00:00', '16:00:00', '2015-11-30', 2, 1, 2558, NULL),
(13, '020123270', 'Basic Information Technology', '13:00:00', '16:00:00', '2015-11-30', 1, 1, 2558, NULL),
(14, '030113260', 'Fundamental Drawing and Management', '17:00:00', '20:00:00', '2015-11-30', 2, 1, 2558, NULL),
(15, '020003101', 'Basic Computer for Education', '09:00:00', '11:00:00', '2015-01-01', 1, 1, 2558, NULL),
(16, '020003101', 'Basic Computer for Education', '09:00:00', '11:00:00', '2015-01-01', 1, 1, 2558, NULL),
(17, '020003101', 'Basic Computer for Education', '09:00:00', '11:00:00', '2015-01-01', 2, 1, 2558, NULL),
(18, '020003101', 'Basic Computer for Education', '09:00:00', '11:00:00', '2015-01-01', 3, 1, 2558, NULL),
(19, '020113190', 'Selected Topics in Mechanical Engineering', '09:00:00', '12:00:00', '2015-01-01', 1, 1, 2558, NULL),
(20, '020133185', 'Selected Topic in Mechatronics Engineering', '09:00:00', '12:00:00', '2015-01-01', 1, 1, 2558, NULL),
(21, '020113960', 'Computer-aided Design and Drawing', '09:00:00', '12:00:00', '2015-01-01', 1, 1, 2558, NULL),
(22, '020123272', 'Production Planning and Inventory Control', '09:00:00', '12:00:00', '2015-01-01', 1, 1, 2558, NULL),
(23, '020123241', 'Tool Engineering', '09:00:00', '12:00:00', '2015-01-01', 1, 1, 2558, NULL),
(24, '020123274', 'Safety Engineering', '13:00:00', '15:00:00', '2015-01-01', 1, 1, 2558, NULL),
(25, '020003202', 'Education Innovation and Information Technology', '13:00:00', '15:00:00', '2015-01-01', 2, 1, 2558, NULL),
(26, '020133927', 'Modern Digital Circuit and Logic Design', '13:00:00', '16:00:00', '2015-01-01', 1, 1, 2558, NULL),
(27, '020113960', 'Computer-aided Design and Drawing', '13:00:00', '16:00:00', '2015-01-01', 2, 1, 2558, NULL),
(28, '020133904', 'Fundamental of Mechanical Engineering', '13:00:00', '16:00:00', '2015-01-01', 1, 1, 2558, NULL),
(29, '020113960', 'Computer-aided Design and Drawing', '17:00:00', '20:00:00', '2015-01-01', 2, 1, 2558, NULL),
(30, '020113970', 'Industrial Electrical Technology', '09:00:00', '12:00:00', '2015-12-02', 1, 1, 2558, NULL),
(31, '020113970', 'Industrial Electrical Technology', '09:00:00', '12:00:00', '2015-12-02', 2, 1, 2558, NULL),
(32, '020133153', 'Image Processing and Machine Vision', '09:00:00', '12:00:00', '2015-12-02', 1, 1, 2558, NULL),
(33, '020113104', 'Physical Metallurgy', '09:00:00', '12:00:00', '2015-12-02', 1, 1, 2558, NULL),
(34, '080303601', 'Human Relations', '13:00:00', '16:00:00', '2015-12-02', 12, 1, 2558, NULL),
(35, '080303603', 'Personality Development', '13:00:00', '16:00:00', '2015-12-02', 1, 1, 2558, NULL),
(36, '020003204', 'Technical Subject Teaching Methods', '13:00:00', '16:00:00', '2015-12-02', 1, 1, 2558, NULL),
(37, '020003204', 'Technical Subject Teaching Methods', '13:00:00', '16:00:00', '2015-12-02', 2, 1, 2558, NULL),
(38, '080103001', 'English I', '09:00:00', '12:00:00', '2015-12-03', 57, 1, 2558, NULL),
(39, '080103001', 'English I', '09:00:00', '12:00:00', '2015-12-03', 58, 1, 2558, NULL),
(40, '080103001', 'Psychology for work', '09:00:00', '12:00:00', '2015-12-03', 5, 1, 2558, NULL),
(41, '040113005', 'Chemistry in Everyday Life', '13:00:00', '16:00:00', '2015-12-03', 5, 1, 2558, NULL),
(42, '020003121', 'Thai Language for Teachers', '13:00:00', '16:00:00', '2015-12-03', 5, 1, 2558, NULL),
(43, '020113912', 'Machine Element Design I', '13:00:00', '16:00:00', '2015-12-03', 1, 1, 2558, NULL),
(44, '040313010', 'Physics', '09:00:00', '12:00:00', '2015-12-04', 1, 1, 2558, NULL),
(45, '020133924', 'Electronic Circuit and Devices I', '09:00:00', '12:00:00', '2015-12-04', 1, 1, 2558, NULL),
(46, '020133951', 'Programmable Logic Controller', '13:00:00', '16:00:00', '2015-12-04', 1, 1, 2558, NULL),
(47, '020113904', 'Engineering Mechanics', '13:00:00', '16:00:00', '2015-12-04', 1, 1, 2558, NULL),
(48, '020133902', 'Measurement and Instrumentation', '09:00:00', '12:00:00', '2015-12-08', 1, 1, 2558, NULL),
(49, '020133113', 'Mechanics of Machinery', '09:00:00', '12:00:00', '2015-12-08', 1, 1, 2558, NULL),
(50, '020113984', 'Automatic Machine Practice', '09:00:00', '12:00:00', '2015-12-08', 1, 1, 2558, NULL),
(51, '020113984', 'Automatic Machine Practice', '09:00:00', '12:00:00', '2015-12-08', 2, 1, 2558, NULL),
(52, '020003206', 'Educational Measurement and Evaluation', '13:00:00', '16:00:00', '2015-12-08', 1, 1, 2558, NULL),
(53, '020003206', 'Educational Measurement and Evaluation', '13:00:00', '16:00:00', '2015-12-08', 2, 1, 2558, NULL),
(54, '020003206', 'Educational Measurement and Evaluation', '13:00:00', '16:00:00', '2015-12-08', 3, 1, 2558, NULL),
(55, '020113930', 'Thermofluids', '13:00:00', '16:00:00', '2015-12-08', 1, 1, 2558, NULL),
(56, '020003103', 'Computer and Programming', '09:00:00', '12:00:00', '2015-12-09', 1, 1, 2558, NULL),
(57, '020003103', 'Computer and Programming', '09:00:00', '12:00:00', '2015-12-09', 2, 1, 2558, NULL),
(58, '020133922', 'Electric Circuit Analysis I', '09:00:00', '12:00:00', '2015-12-09', 2, 1, 2558, NULL),
(59, '020113103', 'Mechanics of Machinery', '09:00:00', '12:00:00', '2015-12-08', 1, 1, 2558, NULL),
(60, '213305', 'Electric Circuit Analysis I', '09:00:00', '12:00:00', '2015-12-09', 1, 1, 2558, NULL),
(61, '080303502', 'Volleyball', '13:00:00', '14:00:00', '2015-12-09', 5, 1, 2558, NULL),
(62, '080303502', 'Volleyball', '13:00:00', '14:00:00', '2015-12-09', 6, 1, 2558, NULL),
(63, '020113902', 'Engineering Statics', '13:00:00', '16:00:00', '2015-12-09', 1, 1, 2558, NULL),
(64, '020123230', 'Metal Removal Process', '13:00:00', '16:00:00', '2015-12-09', 1, 1, 2558, NULL),
(65, '020003203', 'Vocational Education Curriculum Development', '09:00:00', '12:00:00', '2015-12-11', 1, 1, 2558, NULL),
(66, '020003104', 'Electricity in Everyday Life', '09:00:00', '12:00:00', '2015-12-11', 1, 1, 2558, NULL),
(67, '020133923', 'Electric Circuit Analysis II', '09:00:00', '12:00:00', '2015-12-11', 1, 1, 2558, NULL),
(68, '020113121', 'Fluid Mechanics', '09:00:00', '12:00:00', '2015-12-11', 1, 1, 2558, NULL),
(69, '020003210', 'Teaching Media', '13:00:00', '16:00:00', '2015-12-11', 2, 1, 2558, NULL),
(70, '020113903', 'Engineering Dynamics', '13:00:00', '16:00:00', '2015-12-11', 1, 1, 2558, NULL),
(71, '020133906', 'Dynamics for Mechatronics', '13:00:00', '16:00:00', '2015-12-11', 1, 1, 2558, NULL),
(72, '020113114', 'Mechanical Design', '09:00:00', '12:00:00', '2015-12-14', 1, 1, 2558, NULL),
(73, '020003205', 'Psychology for Teachers', '09:00:00', '12:00:00', '2015-12-14', 1, 1, 2558, NULL),
(74, '020113910', 'Mechanics of Solids', '13:00:00', '16:00:00', '2015-12-14', 1, 1, 2558, NULL),
(75, '020113910', 'Mechanics of Solids', '13:00:00', '16:00:00', '2015-12-14', 2, 1, 2558, NULL),
(76, '020133141', 'Sensors and Control Element', '13:00:00', '16:00:00', '2015-12-14', 1, 1, 2558, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`login_id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสข้อมูล', AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสของชื่อผู้ใช้', AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสข้อมูลห้อง', AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสข้อมูล', AUTO_INCREMENT=95;
--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสข้อมูล', AUTO_INCREMENT=77;
--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
