ALTER TABLE `tbl_transactions_log` ADD `details` VARCHAR(500) NOT NULL AFTER `Status`;
UPDATE `tbl_transactions_log` SET `Trans_status`='Received' WHERE `Trans_status` LIKE '%on process%';

-- UPDATE tbl_transactions_log SET Transaction_code = replace(Transaction_code, 'ACCOUNTING', 'ACC');
UPDATE tbl_transactions_log SET From_office='ACC' WHERE From_office='ACCOUNTING';
UPDATE tbl_transactions_log SET Forwarded_to='ACC' WHERE Forwarded_to='ACCOUNTING';

-- UPDATE tbl_transactions_log SET Transaction_code = replace(Transaction_code, 'ADMIN', 'ADM');
UPDATE tbl_transactions_log SET From_office='ADM' WHERE From_office='ADMIN';
UPDATE tbl_transactions_log SET Forwarded_to='ADM' WHERE Forwarded_to='ADMIN';

-- UPDATE tbl_transactions_log SET Transaction_code = replace(Transaction_code, 'ASDS', 'ADS');
UPDATE tbl_transactions_log SET From_office='ADS' WHERE From_office='ASDS';
UPDATE tbl_transactions_log SET Forwarded_to='ADS' WHERE Forwarded_to='ASDS';

-- UPDATE tbl_transactions_log SET Transaction_code = replace(Transaction_code, 'BUDGET', 'BUD');
UPDATE tbl_transactions_log SET From_office='BUD' WHERE From_office='BUDGET';
UPDATE tbl_transactions_log SET Forwarded_to='BUD' WHERE Forwarded_to='BUDGET';

-- UPDATE tbl_transactions_log SET Transaction_code = replace(Transaction_code, 'CASHIER', 'CSH');
UPDATE tbl_transactions_log SET From_office='CSH' WHERE From_office='CASHIER';
UPDATE tbl_transactions_log SET Forwarded_to='CSH' WHERE Forwarded_to='CASHIER';

-- UPDATE tbl_transactions_log SET Transaction_code = replace(Transaction_code, 'PHYSICAL', 'GSS');
UPDATE tbl_transactions_log SET From_office='GSS' WHERE From_office='PHYSICAL';
UPDATE tbl_transactions_log SET Forwarded_to='GSS' WHERE Forwarded_to='PHYSICAL';

-- UPDATE tbl_transactions_log SET Transaction_code = replace(Transaction_code, 'HEALTH', 'HNS');
UPDATE tbl_transactions_log SET From_office='HNS' WHERE From_office='HEALTH';
UPDATE tbl_transactions_log SET Forwarded_to='HNS' WHERE Forwarded_to='HEALTH';

-- UPDATE tbl_transactions_log SET Transaction_code = replace(Transaction_code, 'HRMO', 'PER');
UPDATE tbl_transactions_log SET From_office='PER' WHERE From_office='HRMO';
UPDATE tbl_transactions_log SET Forwarded_to='PER' WHERE Forwarded_to='HRMO';

-- UPDATE tbl_transactions_log SET Transaction_code = replace(Transaction_code, 'ITO', 'ICT');
UPDATE tbl_transactions_log SET From_office='ICT' WHERE From_office='ITO';
UPDATE tbl_transactions_log SET Forwarded_to='ICT' WHERE Forwarded_to='ITO';

-- UPDATE tbl_transactions_log SET Transaction_code = replace(Transaction_code, 'LEGAL', 'LGL');
UPDATE tbl_transactions_log SET From_office='LGL' WHERE From_office='LEGAL';
UPDATE tbl_transactions_log SET Forwarded_to='LGL' WHERE Forwarded_to='LEGAL';

-- UPDATE tbl_transactions_log SET Transaction_code = replace(Transaction_code, 'LRMDS', 'LRM');
UPDATE tbl_transactions_log SET From_office='LRM' WHERE From_office='LRMDS';
UPDATE tbl_transactions_log SET Forwarded_to='LRM' WHERE Forwarded_to='LRMDS';

-- UPDATE tbl_transactions_log SET Transaction_code = replace(Transaction_code, 'LRMS', 'LRM');
UPDATE tbl_transactions_log SET From_office='LRM' WHERE From_office='LRMS';
UPDATE tbl_transactions_log SET Forwarded_to='LRM' WHERE Forwarded_to='LRMS';

-- UPDATE tbl_transactions_log SET Transaction_code = replace(Transaction_code, 'OSDS', 'SDS');
UPDATE tbl_transactions_log SET From_office='SDS' WHERE From_office='OSDS';
UPDATE tbl_transactions_log SET Forwarded_to='SDS' WHERE Forwarded_to='OSDS';

-- UPDATE tbl_transactions_log SET Transaction_code = replace(Transaction_code, 'PSDS', 'PDS');
UPDATE tbl_transactions_log SET From_office='PDS' WHERE From_office='PSDS';
UPDATE tbl_transactions_log SET Forwarded_to='PDS' WHERE Forwarded_to='PSDS';

-- UPDATE tbl_transactions_log SET Transaction_code = replace(Transaction_code, 'RECORD', 'REC');
UPDATE tbl_transactions_log SET From_office='REC' WHERE From_office='RECORD';
UPDATE tbl_transactions_log SET Forwarded_to='REC' WHERE Forwarded_to='RECORD';

-- UPDATE tbl_transactions_log SET Transaction_code = replace(Transaction_code, 'SGOD', 'SGD');
UPDATE tbl_transactions_log SET From_office='SGD' WHERE From_office='SGOD';
UPDATE tbl_transactions_log SET Forwarded_to='SGD' WHERE Forwarded_to='SGOD';

-- UPDATE tbl_transactions_log SET Transaction_code = replace(Transaction_code, 'SUPPLY', 'PSS');
UPDATE tbl_transactions_log SET From_office='PSS' WHERE From_office='SUPPLY';
UPDATE tbl_transactions_log SET Forwarded_to='PSS' WHERE Forwarded_to='SUPPLY';

/* DONE */