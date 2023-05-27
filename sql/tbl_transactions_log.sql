/* TO BE EXECUTED BEFORE LAUNCH */
UPDATE `tbl_transactions_log` SET `Trans_status`='Received' WHERE `Trans_status` LIKE '%on process%';

SELECT * FROM `tbl_transactions_log` WHERE `Trans_status` LIKE '%on process%';

SELECT `Transaction_code` AS `id`, COUNT(*) AS `instance`, `Status` AS `status` FROM `tbl_transactions_log` GROUP BY `Transaction_code`, `Status` ORDER BY `status` DESC, COUNT(*) DESC;

/* CHANGE PHYSICAL TO GSS (GENERAL SERVICES SECTION) */
SELECT * FROM `tbl_transactions_log` WHERE Transaction_code LIKE '%PHYSICAL%' OR From_office='PHYSICAL' OR Forwarded_to='PHYSICAL';
UPDATE tbl_transactions_log SET Transaction_code = replace(Transaction_code, 'PHYSICAL', 'GSS');
UPDATE tbl_transactions_log SET From_office='GSS' WHERE From_office='PHYSICAL';
UPDATE tbl_transactions_log SET Forwarded_to='GSS' WHERE Forwarded_to='PHYSICAL';
SELECT * FROM `tbl_transactions_log` WHERE Transaction_code LIKE '%GSS%' OR From_office='GSS' OR Forwarded_to='GSS';
ALTER TABLE `tbl_transactions_log` ADD `details` VARCHAR(500) NOT NULL AFTER `Status`;