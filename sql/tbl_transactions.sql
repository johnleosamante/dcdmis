UPDATE `tbl_transactions` SET `Status`='Read' WHERE `Trans_Stats` LIKE '%complete%';
UPDATE `tbl_transactions` SET `Status`='Read' WHERE `Trans_Stats` LIKE '%cancel%';
UPDATE `tbl_transactions` SET `Trans_Stats`='Received' WHERE `Trans_stats` LIKE '%on process%';

-- UPDATE tbl_transactions SET TransCode = replace(TransCode, 'ACCOUNTING', 'ACC');
UPDATE tbl_transactions SET Trans_from = 'ACC' WHERE Trans_from = 'ACCOUNTING';

-- UPDATE tbl_transactions SET TransCode = replace(TransCode, 'ADMIN', 'ADM');
UPDATE tbl_transactions SET Trans_from = 'ADM' WHERE Trans_from = 'ADMIN';

-- UPDATE tbl_transactions SET TransCode = replace(TransCode, 'ASDS', 'ADS');
UPDATE tbl_transactions SET Trans_from = 'ADS' WHERE Trans_from = 'ASDS';

-- #UPDATE tbl_transactions SET TransCode = replace(TransCode, 'BUDGET', 'BUD');
UPDATE tbl_transactions SET Trans_from = 'BUD' WHERE Trans_from = 'BUDGET';

-- UPDATE tbl_transactions SET TransCode = replace(TransCode, 'CASHIER', 'CSH');
UPDATE tbl_transactions SET Trans_from = 'CSH' WHERE Trans_from = 'CASHIER';

-- UPDATE tbl_transactions SET TransCode = replace(TransCode, 'PHYSICAL', 'GSS');
UPDATE tbl_transactions SET Trans_from = 'GSS' WHERE Trans_from = 'PHYSICAL';

-- UPDATE tbl_transactions SET TransCode = replace(TransCode, 'HEALTH', 'HNS');
UPDATE tbl_transactions SET Trans_from = 'HNS' WHERE Trans_from = 'HEALTH';

-- UPDATE tbl_transactions SET TransCode = replace(TransCode, 'HRMO', 'PER');
UPDATE tbl_transactions SET Trans_from = 'PER' WHERE Trans_from = 'HRMO';

-- UPDATE tbl_transactions SET TransCode = replace(TransCode, 'ITO', 'ICT');
UPDATE tbl_transactions SET Trans_from = 'ICT' WHERE Trans_from = 'ITO';

-- UPDATE tbl_transactions SET TransCode = replace(TransCode, 'LEGAL', 'LGL');
UPDATE tbl_transactions SET Trans_from = 'LGL' WHERE Trans_from = 'LEGAL';

-- UPDATE tbl_transactions SET TransCode = replace(TransCode, 'LRMDS', 'LRM');
UPDATE tbl_transactions SET Trans_from = 'LRM' WHERE Trans_from = 'LRMDS';

-- UPDATE tbl_transactions SET TransCode = replace(TransCode, 'LRMS', 'LRM');
UPDATE tbl_transactions SET Trans_from = 'LRM' WHERE Trans_from = 'LRMS';

-- UPDATE tbl_transactions SET TransCode = replace(TransCode, 'OSDS', 'SDS');
UPDATE tbl_transactions SET Trans_from = 'SDS' WHERE Trans_from = 'OSDS';

-- UPDATE tbl_transactions SET TransCode = replace(TransCode, 'PSDS', 'PDS');
UPDATE tbl_transactions SET Trans_from = 'PDS' WHERE Trans_from = 'PSDS';

-- UPDATE tbl_transactions SET TransCode = replace(TransCode, 'RECORD', 'REC');
UPDATE tbl_transactions SET Trans_from = 'REC' WHERE Trans_from = 'RECORD';

-- UPDATE tbl_transactions SET TransCode = replace(TransCode, 'SGOD', 'SGD');
UPDATE tbl_transactions SET Trans_from = 'SGD' WHERE Trans_from = 'SGOD';

-- UPDATE tbl_transactions SET TransCode = replace(TransCode, 'SUPPLY', 'PSS');
UPDATE tbl_transactions SET Trans_from = 'PSS' WHERE Trans_from = 'SUPPLY';

UPDATE `tbl_transactions` SET `SchoolID`='143' WHERE `SchoolID`='123131';

ALTER TABLE `tbl_transactions` ADD `details` VARCHAR(500) NOT NULL AFTER `Attachfile`;

/* DONE */