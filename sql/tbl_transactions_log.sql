UPDATE `tbl_transactions_log` SET `Trans_status`='Received' WHERE `Trans_status` LIKE '%on process%';

SELECT * FROM `tbl_transactions_log` WHERE `Trans_status` LIKE '%on process%';