/* CHANGE PHYSICAL TO GSS (GENERAL SERVICES SECTION) */
SELECT * FROM `tbl_transaction_flow` WHERE TransactionCode LIKE '%PHYSICAL%' OR Destination_section='PHYSICAL';

UPDATE tbl_transaction_flow SET SchoolID='143' WHERE SchoolID='123131';