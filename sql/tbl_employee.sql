ALTER TABLE `tbl_employee` ADD `Emp_GSIS_BP` VARCHAR(20) NOT NULL AFTER `Emp_GSIS`;

ALTER TABLE `tbl_employee` ADD `Emp_Alternate_Email` VARCHAR(100) NOT NULL AFTER `Emp_Email`;

ALTER TABLE `tbl_employee` ADD `Emp_Alternate_Cell_No` VARCHAR(20) NOT NULL AFTER `Emp_Cell_No`;

ALTER TABLE `tbl_employee` ADD `beforeTitle` VARCHAR(50) NOT NULL AFTER `Emp_Status`, ADD `afterTitle` VARCHAR(50) NOT NULL AFTER `beforeTitle`;

UPDATE `tbl_employee` SET `Emp_Status`='Duplicate' WHERE `Emp_Status`='Removed';

UPDATE `tbl_employee` SET `Emp_Status`='Transferred' WHERE `Emp_Status`='De-Activate';

/* DONE */