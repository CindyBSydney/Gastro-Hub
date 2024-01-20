/********************************************** Table 1 *****************************************************/
CREATE TABLE IF NOT EXISTS `tbl_user_clearance_level` (
    `clearance_level_id` int(11) NOT NULL AUTO_INCREMENT,
    `clearance_level_code` enum('L1','L2', 'L3', 'L4', 'L5') NOT NULL, -- L1 = System Admin, L2 = Oncologist, L3 = Radiologist, L4 = Nurse, L5 = Receptionist
    `clearance_level` varchar(100) NOT NULL,
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`clearance_level_id`),
    UNIQUE(`clearance_level`)
);
ALTER TABLE `tbl_user_clearance_level` AUTO_INCREMENT=76145572;

/********************************************** Table 2 *****************************************************/
-- Receptionist, Nurse, Oncologist, Radiologist, System Admin

CREATE TABLE IF NOT EXISTS `tbl_user` (
    `user_id` int(11) NOT NULL AUTO_INCREMENT,
    `email` varchar(120) NOT NULL,
    `password` varchar(200) NOT NULL,
    `first_name` varchar(100) NOT NULL,
    `last_name` varchar(100) NOT NULL,
    `profile_image` varchar(200) NULL,
    `google_auth_code` varchar(16) NOT NULL,
    `clearance_level_id` int(11) NOT NULL,
    `clearance_level_code` enum('L1','L2', 'L3', 'L4', 'L5') NOT NULL,
    `clearance_level` varchar(100) NOT NULL, -- L1 = System Admin, L2 = Oncologist, L3 = Radiologist, L4 = Nurse, L5 = Receptionist
    `is_verified` tinyint(1) DEFAULT 0 NOT NULL,
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`user_id`),
    UNIQUE(`email`),
    UNIQUE(`google_auth_code`),
    FOREIGN KEY (`clearance_level_id`) REFERENCES `tbl_user_clearance_level`(`clearance_level_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`clearance_level`) REFERENCES `tbl_user_clearance_level`(`clearance_level`) ON DELETE CASCADE ON UPDATE CASCADE
);
ALTER TABLE `tbl_user` AUTO_INCREMENT=25257672;
ALTER TABLE `tbl_user`
ADD COLUMN `suspended` ENUM('0', '1') NOT NULL DEFAULT '0',
ADD COLUMN `deactivated` ENUM('0', '1') NOT NULL DEFAULT '0';
ALTER TABLE `tbl_user` ADD COLUMN `disabled_end_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `tbl_user` ADD COLUMN `is_available` ENUM('0', '1') NOT NULL DEFAULT '0' AFTER `profile_image`; -- 0 = not available, 1 = available
ALTER TABLE `tbl_user` ADD COLUMN `processing` ENUM('0', '1') NOT NULL DEFAULT '0' AFTER `is_available`; -- 0 = not processing, 1 = processing



/********************************************** Table 3 *****************************************************/
-- Patient
CREATE TABLE IF NOT EXISTS `tbl_patient` (
    `patient_id` int(11) NOT NULL AUTO_INCREMENT,
    `first_name` varchar(100) NOT NULL,
    `last_name` varchar(100) NOT NULL,
    `guardian_name` varchar(100) NULL,
    `dob` varchar(10) NOT NULL, -- DD/MM/YYYY
    `phone_number` varchar(13) NOT NULL, -- +254 700 000 000
    `insured` enum('0', '1') DEFAULT '0' NOT NULL, -- 0 = not insured, 1 = insured
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`patient_id`),
    UNIQUE(`phone_number`)
);
ALTER TABLE `tbl_patient` AUTO_INCREMENT=46513599;


/********************************************** Table 4 *****************************************************/
-- Patient visit
CREATE TABLE IF NOT EXISTS `tbl_patient_visit` (
    `patient_visit_id` int(11) NOT NULL AUTO_INCREMENT,
    `patient_id` int(11) NOT NULL,
    `triage_queue_number` int(11) NOT NULL,
    `oncologist_queue_number` int(11) NULL,
    `radiologist_queue_number` int(11) NULL,
    `visit_status` enum('0', '1', '2', '3', '4', '5', '6', '7', '8') DEFAULT '0' NOT NULL, 
    /* 
    visit_status:
    0 = idle state (default), 
    1 = in triage queue, 
    2 = in oncologist queue (Initial consultation),
    3 = in radiologist queue (Cancer detection queue),
    4 = in oncologist queue (Cancer results queue),
    5 = in radiologist queue (MSI/MSS detection),
    6 = in oncologist queue (MSI/MSS results queue),
    7 = visit incomplete (patient left before completion)
    8 = visit complete (patient left after completion / discharged)
    */
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`patient_visit_id`),
    UNIQUE(`triage_queue_number`),
    UNIQUE(`oncologist_queue_number`),
    UNIQUE(`radiologist_queue_number`),
    FOREIGN KEY (`patient_id`) REFERENCES `tbl_patient`(`patient_id`) ON DELETE CASCADE ON UPDATE CASCADE
);
ALTER TABLE `tbl_patient_visit` AUTO_INCREMENT=35994651;
ALTER TABLE `tbl_patient_visit` ADD CONSTRAINT `uc_patient_visit` UNIQUE (patient_id, visit_status);


/********************************************** Table 5 *****************************************************/
-- Triage
CREATE TABLE IF NOT EXISTS `tbl_triage` (
    `triage_record_id` int(11) NOT NULL AUTO_INCREMENT,
    `patient_visit_id` int(11) NOT NULL,
    `patient_id` int(11) NOT NULL,
    `blood_type` enum('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-') NOT NULL,
    `height` int(4) NOT NULL, -- in cm
    `weight` int(4) NOT NULL, -- in kg
    `blood_pressure_systolic` int(3) NOT NULL, -- mmHg upper number
    `blood_pressure_diastolic` int(3) NOT NULL, -- mmHg lower number
    `temperature` int(2) NOT NULL, -- in celcius
    `signs_and_symptoms` varchar(200) NOT NULL,
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`triage_record_id`),
    UNIQUE(`patient_visit_id`),
    FOREIGN KEY (`patient_visit_id`) REFERENCES `tbl_patient_visit`(`patient_visit_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`patient_id`) REFERENCES `tbl_patient`(`patient_id`) ON DELETE CASCADE ON UPDATE CASCADE
);
ALTER TABLE `tbl_triage` AUTO_INCREMENT=13594671;

/********************************************** Table 6 *****************************************************/
-- Patient commentary
CREATE TABLE IF NOT EXISTS `tbl_patient_commentary` (
    `patient_commentary_id` int(11) NOT NULL AUTO_INCREMENT,
    `triage_record_id` int(11) NOT NULL,
    `patient_visit_id` int(11) NOT NULL,
    `patient_id` int(11) NOT NULL,
    `oncologist_general_comment` varchar(200) NULL,
    `cancer_detection_approval` enum('0', '1', '2') DEFAULT '0' NOT NULL, -- 0 = not approved, 1 = approved, 2 = rejected
    `radiologist_cancer_comment` varchar(200) NULL,
    `cancer_stage` enum('0', '1', '2', '3', '4') DEFAULT '0' NOT NULL, -- 0 = no cancer, 1 = stage 1, 2 = stage 2, 3 = stage 3, 4 = stage 4
    `oncologist_cancer_comment` varchar(200) NULL,
    `msi_mss_detection_approval` enum('0', '1', '2') DEFAULT '0' NOT NULL, -- 0 = not approved, 1 = approved, 2 = rejected
    `radiologist_msi_mss_comment` varchar(200) NULL,
    `msi_mss_status` enum('0', '1') DEFAULT '0' NOT NULL, -- 0 = MSI, 1 = MSS
    `oncologist_msi_mss_comment` varchar(200) NULL,
    `oncologist_prescription` varchar(200) NULL,
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`patient_commentary_id`),
    UNIQUE(`triage_record_id`),
    UNIQUE(`patient_visit_id`),
    UNIQUE(`patient_id`),
    FOREIGN KEY (`triage_record_id`) REFERENCES `tbl_triage`(`triage_record_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`patient_visit_id`) REFERENCES `tbl_patient_visit`(`patient_visit_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`patient_id`) REFERENCES `tbl_patient`(`patient_id`) ON DELETE CASCADE ON UPDATE CASCADE
);
ALTER TABLE `tbl_patient_commentary` AUTO_INCREMENT=19463551;

/********************************************** Table 7 *****************************************************/
CREATE TABLE IF NOT EXISTS `tbl_login_attempts` (
    `attempt_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `email` varchar(120) NOT NULL,
    `last_login_attempt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `num_attempts` tinyint(1) DEFAULT 0 NOT NULL,
    PRIMARY KEY (`attempt_id`),
    UNIQUE(`user_id`),
    UNIQUE(`email`),
    FOREIGN KEY (`user_id`) REFERENCES `tbl_user`(`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`email`) REFERENCES `tbl_user`(`email`) ON DELETE CASCADE ON UPDATE CASCADE
);
ALTER TABLE `tbl_login_attempts` AUTO_INCREMENT=15767245;
