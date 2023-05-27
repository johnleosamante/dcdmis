/* TO BE EXECUTED BEFORE LAUNCH */
UPDATE `tbl_transactions` SET `Status`='Read' WHERE `Trans_Stats` LIKE '%complete%';
UPDATE `tbl_transactions` SET `Status`='Read' WHERE `Trans_Stats` LIKE '%cancel%';
UPDATE `tbl_transactions` SET `Trans_Stats`='Received' WHERE `Trans_stats` LIKE '%on process%';

SELECT * FROM `tbl_transactions` WHERE `Trans_Stats` LIKE '%complete%' OR `Trans_Stats` LIKE '%cancel%';

/* CHANGE PHYSICAL TO GSS (GENERAL SERVICES SECTION) */
SELECT * FROM `tbl_transactions` WHERE TransCode LIKE '%PHYSICAL%';
UPDATE tbl_transactions SET TransCode = replace(TransCode, 'PHYSICAL', 'GSS');
SELECT * FROM `tbl_transactions` WHERE TransCode LIKE '%GSS%';
UPDATE tbl_transactions SET Trans_from = 'GSS' WHERE Trans_from = 'PHYSICAL';

/* CHANGE DIVISION SCHOOL ID */
UPDATE `tbl_transactions` SET `SchoolID`='143' WHERE `SchoolID`='123131';

ALTER TABLE `tbl_transactions` ADD `details` VARCHAR(500) NOT NULL AFTER `Attachfile`;