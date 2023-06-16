ALTER TABLE `tbl_employee` ADD `Emp_GSIS_BP` VARCHAR(20) NOT NULL AFTER `Emp_GSIS`;

ALTER TABLE `tbl_employee` ADD `Emp_Alternate_Email` VARCHAR(100) NOT NULL AFTER `Emp_Email`;

ALTER TABLE `tbl_employee` ADD `Emp_Alternate_Cell_No` VARCHAR(20) NOT NULL AFTER `Emp_Cell_No`;