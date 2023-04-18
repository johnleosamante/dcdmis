/* TO BE EXECUTED BEFORE LAUNCH */
UPDATE `tbl_transactions` SET `Status`='Read' WHERE `Trans_Stats` LIKE '%complete%';
UPDATE `tbl_transactions` SET `Status`='Read' WHERE `Trans_Stats` LIKE '%cancel%';
UPDATE `tbl_transactions` SET `Trans_Stats`='Received' WHERE `Trans_stats` LIKE '%on process%';

SELECT * FROM `tbl_transactions` WHERE `Trans_Stats` LIKE '%complete%' OR `Trans_Stats` LIKE '%cancel%';

/* CHANGE PHYSICAL TO GSS (General Services Section) */
SELECT * FROM `tbl_transactions` WHERE TransCode LIKE '%PHYSICAL%';
SELECT * FROM `tbl_transactions_log` WHERE Transaction_code LIKE '%PHYSICAL%' OR From_office='PHYSICAL' OR Forwarded_to='PHYSICAL';
SELECT * FROM `tbl_transaction_flow` WHERE TransactionCode LIKE '%PHYSICAL%' OR Destination_section='PHYSICAL';