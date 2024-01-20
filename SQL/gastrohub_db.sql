-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2023 at 06:54 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gastrohub_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_login_attempts`
--

CREATE TABLE `tbl_login_attempts` (
  `attempt_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(120) NOT NULL,
  `last_login_attempt` timestamp NOT NULL DEFAULT current_timestamp(),
  `num_attempts` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_login_attempts`
--

INSERT INTO `tbl_login_attempts` (`attempt_id`, `user_id`, `email`, `last_login_attempt`, `num_attempts`) VALUES
(15767245, 25257673, 'lgachanja@gastrohub.com', '2023-09-04 17:45:14', 0),
(15767246, 25257674, 'pmwangi@gastrohub.com', '2023-09-04 17:51:38', 0),
(15767247, 25257675, 'jbaraka@gastrohub.com', '2023-09-04 17:53:38', 0),
(15767248, 25257676, 'msarange@gastrohub.com', '2023-09-04 17:54:52', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_patient`
--

CREATE TABLE `tbl_patient` (
  `patient_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `guardian_name` varchar(100) DEFAULT NULL,
  `dob` varchar(10) NOT NULL,
  `phone_number` varchar(13) NOT NULL,
  `insured` enum('0','1') NOT NULL DEFAULT '0',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_patient`
--

INSERT INTO `tbl_patient` (`patient_id`, `first_name`, `last_name`, `guardian_name`, `dob`, `phone_number`, `insured`, `updated_at`, `created_at`) VALUES
(46513599, 'George', 'Kamau', ' ', '20/06/1996', '+254739234263', '1', '2023-09-05 17:17:54', '2023-09-05 17:17:54'),
(46513604, 'Yusuf', 'Otieno', ' ', '19/11/1986', '+254756815525', '0', '2023-09-06 07:35:38', '2023-09-06 07:35:38'),
(46513605, 'John', 'Doe', ' ', '12/11/1996', '+254722580930', '1', '2023-09-06 07:37:48', '2023-09-06 07:37:48');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_patient_commentary`
--

CREATE TABLE `tbl_patient_commentary` (
  `patient_commentary_id` int(11) NOT NULL,
  `triage_record_id` int(11) NOT NULL,
  `patient_visit_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `oncologist_general_comment` varchar(200) DEFAULT NULL,
  `cancer_detection_approval` enum('0','1','2') NOT NULL DEFAULT '0',
  `radiologist_cancer_comment` varchar(200) DEFAULT NULL,
  `cancer_stage` enum('0','1','2','3','4') NOT NULL DEFAULT '0',
  `oncologist_cancer_comment` varchar(200) DEFAULT NULL,
  `msi_mss_detection_approval` enum('0','1','2') NOT NULL DEFAULT '0',
  `radiologist_msi_mss_comment` varchar(200) DEFAULT NULL,
  `msi_mss_status` enum('0','1') NOT NULL DEFAULT '0',
  `oncologist_msi_mss_comment` varchar(200) DEFAULT NULL,
  `oncologist_prescription` varchar(200) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_patient_visit`
--

CREATE TABLE `tbl_patient_visit` (
  `patient_visit_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `triage_queue_number` int(11) NOT NULL,
  `oncologist_queue_number` int(11) DEFAULT NULL,
  `radiologist_queue_number` int(11) DEFAULT NULL,
  `visit_status` enum('0','1','2','3','4','5','6','7','8') NOT NULL DEFAULT '0',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_triage`
--

CREATE TABLE `tbl_triage` (
  `triage_record_id` int(11) NOT NULL,
  `patient_visit_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `blood_type` enum('A+','A-','B+','B-','AB+','AB-','O+','O-') NOT NULL,
  `height` int(4) NOT NULL,
  `weight` int(4) NOT NULL,
  `blood_pressure_systolic` int(3) NOT NULL,
  `blood_pressure_diastolic` int(3) NOT NULL,
  `temperature` int(2) NOT NULL,
  `signs_and_symptoms` varchar(200) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL,
  `email` varchar(120) NOT NULL,
  `password` varchar(200) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `profile_image` varchar(200) DEFAULT NULL,
  `is_available` enum('0','1') NOT NULL DEFAULT '0',
  `processing` enum('0','1') NOT NULL DEFAULT '0',
  `google_auth_code` varchar(16) NOT NULL,
  `clearance_level_id` int(11) NOT NULL,
  `clearance_level_code` enum('L1','L2','L3','L4','L5') NOT NULL,
  `clearance_level` varchar(100) NOT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `suspended` enum('0','1') NOT NULL DEFAULT '0',
  `deactivated` enum('0','1') NOT NULL DEFAULT '0',
  `disabled_end_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `email`, `password`, `first_name`, `last_name`, `profile_image`, `is_available`, `processing`, `google_auth_code`, `clearance_level_id`, `clearance_level_code`, `clearance_level`, `is_verified`, `updated_at`, `created_at`, `suspended`, `deactivated`, `disabled_end_date`) VALUES
(25257672, 'cbosibori@gastrohub.com', 'a1259dfcd674d406560d52ae2d4ad727', 'Cindy', 'Bosibori', NULL, '0', '0', 'TSG2PO7VVQFV2LC4', 76145572, 'L1', 'System Admin', 0, '2023-09-03 17:05:18', '2023-09-03 17:05:18', '0', '0', '2023-09-03 17:05:18'),
(25257673, 'lgachanja@gastrohub.com', '5db7110de69db7a4ef3d764de8f66b12', 'Lorraine', 'Gachanja', NULL, '0', '0', 'QJGVRHRBLTPUNKEA', 76145573, 'L2', 'Oncologist', 0, '2023-09-04 17:45:14', '2023-09-04 17:45:14', '0', '0', '2023-09-04 17:45:14'),
(25257674, 'pmwangi@gastrohub.com', '281152810edc47909d590317cceafe14', 'Phil', 'Mwangi', NULL, '0', '0', 'GML5VT3UYIV5LQ3W', 76145575, 'L4', 'Nurse', 0, '2023-09-04 17:51:38', '2023-09-04 17:51:38', '0', '0', '2023-09-04 17:51:38'),
(25257675, 'jbaraka@gastrohub.com', '6b648a790c909139b60ac6e0f38c5afb', 'Jonathan', 'Baraka', NULL, '0', '0', 'NWXOJ6AAECMBSRUP', 76145574, 'L3', 'Radiologist', 0, '2023-09-04 17:53:38', '2023-09-04 17:53:38', '0', '0', '2023-09-04 17:53:38'),
(25257676, 'msarange@gastrohub.com', '5333b6665462b129183b1a7e3cd2fe15', 'Michelle', 'Sarange', NULL, '0', '0', 'AAG6NAEHQTFQR3HA', 76145576, 'L5', 'Receptionist', 0, '2023-09-04 17:54:52', '2023-09-04 17:54:52', '0', '0', '2023-09-04 17:54:52');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_clearance_level`
--

CREATE TABLE `tbl_user_clearance_level` (
  `clearance_level_id` int(11) NOT NULL,
  `clearance_level_code` enum('L1','L2','L3','L4','L5') NOT NULL,
  `clearance_level` varchar(100) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user_clearance_level`
--

INSERT INTO `tbl_user_clearance_level` (`clearance_level_id`, `clearance_level_code`, `clearance_level`, `updated_at`, `created_at`) VALUES
(76145572, 'L1', 'System Admin', '2023-09-03 16:58:02', '2023-09-03 16:58:02'),
(76145573, 'L2', 'Oncologist', '2023-09-03 16:58:14', '2023-09-03 16:58:14'),
(76145574, 'L3', 'Radiologist', '2023-09-03 16:58:28', '2023-09-03 16:58:28'),
(76145575, 'L4', 'Nurse', '2023-09-03 16:58:39', '2023-09-03 16:58:39'),
(76145576, 'L5', 'Receptionist', '2023-09-03 16:58:51', '2023-09-03 16:58:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_login_attempts`
--
ALTER TABLE `tbl_login_attempts`
  ADD PRIMARY KEY (`attempt_id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tbl_patient`
--
ALTER TABLE `tbl_patient`
  ADD PRIMARY KEY (`patient_id`),
  ADD UNIQUE KEY `phone_number` (`phone_number`);

--
-- Indexes for table `tbl_patient_commentary`
--
ALTER TABLE `tbl_patient_commentary`
  ADD PRIMARY KEY (`patient_commentary_id`),
  ADD UNIQUE KEY `triage_record_id` (`triage_record_id`),
  ADD UNIQUE KEY `patient_visit_id` (`patient_visit_id`),
  ADD UNIQUE KEY `patient_id` (`patient_id`);

--
-- Indexes for table `tbl_patient_visit`
--
ALTER TABLE `tbl_patient_visit`
  ADD PRIMARY KEY (`patient_visit_id`),
  ADD UNIQUE KEY `triage_queue_number` (`triage_queue_number`),
  ADD UNIQUE KEY `uc_patient_visit` (`patient_id`,`visit_status`),
  ADD UNIQUE KEY `oncologist_queue_number` (`oncologist_queue_number`),
  ADD UNIQUE KEY `radiologist_queue_number` (`radiologist_queue_number`);

--
-- Indexes for table `tbl_triage`
--
ALTER TABLE `tbl_triage`
  ADD PRIMARY KEY (`triage_record_id`),
  ADD UNIQUE KEY `patient_visit_id` (`patient_visit_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `google_auth_code` (`google_auth_code`),
  ADD KEY `clearance_level_id` (`clearance_level_id`),
  ADD KEY `clearance_level` (`clearance_level`);

--
-- Indexes for table `tbl_user_clearance_level`
--
ALTER TABLE `tbl_user_clearance_level`
  ADD PRIMARY KEY (`clearance_level_id`),
  ADD UNIQUE KEY `clearance_level` (`clearance_level`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_login_attempts`
--
ALTER TABLE `tbl_login_attempts`
  MODIFY `attempt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15767249;

--
-- AUTO_INCREMENT for table `tbl_patient`
--
ALTER TABLE `tbl_patient`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46513606;

--
-- AUTO_INCREMENT for table `tbl_patient_commentary`
--
ALTER TABLE `tbl_patient_commentary`
  MODIFY `patient_commentary_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19463556;

--
-- AUTO_INCREMENT for table `tbl_patient_visit`
--
ALTER TABLE `tbl_patient_visit`
  MODIFY `patient_visit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35994685;

--
-- AUTO_INCREMENT for table `tbl_triage`
--
ALTER TABLE `tbl_triage`
  MODIFY `triage_record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13594700;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25257677;

--
-- AUTO_INCREMENT for table `tbl_user_clearance_level`
--
ALTER TABLE `tbl_user_clearance_level`
  MODIFY `clearance_level_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76145577;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_login_attempts`
--
ALTER TABLE `tbl_login_attempts`
  ADD CONSTRAINT `tbl_login_attempts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_login_attempts_ibfk_2` FOREIGN KEY (`email`) REFERENCES `tbl_user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_patient_commentary`
--
ALTER TABLE `tbl_patient_commentary`
  ADD CONSTRAINT `tbl_patient_commentary_ibfk_1` FOREIGN KEY (`triage_record_id`) REFERENCES `tbl_triage` (`triage_record_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_patient_commentary_ibfk_2` FOREIGN KEY (`patient_visit_id`) REFERENCES `tbl_patient_visit` (`patient_visit_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_patient_commentary_ibfk_3` FOREIGN KEY (`patient_id`) REFERENCES `tbl_patient` (`patient_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_patient_visit`
--
ALTER TABLE `tbl_patient_visit`
  ADD CONSTRAINT `tbl_patient_visit_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `tbl_patient` (`patient_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_triage`
--
ALTER TABLE `tbl_triage`
  ADD CONSTRAINT `tbl_triage_ibfk_1` FOREIGN KEY (`patient_visit_id`) REFERENCES `tbl_patient_visit` (`patient_visit_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_triage_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `tbl_patient` (`patient_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD CONSTRAINT `tbl_user_ibfk_1` FOREIGN KEY (`clearance_level_id`) REFERENCES `tbl_user_clearance_level` (`clearance_level_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_user_ibfk_2` FOREIGN KEY (`clearance_level`) REFERENCES `tbl_user_clearance_level` (`clearance_level`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
