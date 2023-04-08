UPDATE `tbl_transactions` SET `Status`='Read' WHERE `Trans_Stats` LIKE '%complete%';
UPDATE `tbl_transactions` SET `Status`='Read' WHERE `Trans_Stats` LIKE '%cancel%';
UPDATE `tbl_transactions` SET `Trans_Stats`='Received' WHERE `Trans_stats` LIKE '%on process%';

SELECT * FROM `tbl_transactions` WHERE `Trans_Stats` LIKE '%complete%' OR `Trans_Stats` LIKE '%cancel%';