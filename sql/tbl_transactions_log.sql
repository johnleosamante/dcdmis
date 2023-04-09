UPDATE `tbl_transactions_log` SET `Trans_status`='Received' WHERE `Trans_status` LIKE '%on process%';

SELECT * FROM `tbl_transactions_log` WHERE `Trans_status` LIKE '%on process%';

SELECT `Transaction_code` AS `id`, COUNT(*) AS `instance`, `Status` AS `status` FROM `tbl_transactions_log` WHERE `From_office`='HRMO' GROUP BY `Transaction_code`, `Status` ORDER BY `status` DESC, COUNT(*) DESC;