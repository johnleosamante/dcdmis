CREATE TABLE `tbl_div_section` (
  `Section_Code` varchar(15) NOT NULL DEFAULT '0',
  `Section_Incharge` varchar(50) DEFAULT NULL,
  `Section_Office` varchar(100) DEFAULT NULL
);

INSERT INTO `tbl_div_section` (`Section_Code`, `Section_Incharge`, `Section_Office`) VALUES
('ACCOUNTING', '221110380000', 'Accounting Section'),
('ADMIN', '221110470000', 'Administrative Section'),
('ASDS', '202211190000', 'Office of the Assistant Schools Division Superintendent'),
('BAC', '202211190000', 'Bidding & Awards Committee'),
('BUDGET', '221110470000', 'Budget Section'),
('CASHIER', '221111410000', 'Cash Section'),
('CID', '221111450000', 'Office of the Curriculum Implementation Division Chief'),
('EPS', '221111450000', 'Education Program Supervisor'),
('GSS', '221117390000', 'General Services Section'),
('HEALTH', '221116590000', 'Health & Nutrition Section'),
('HRMO', '221111180000', 'Personnel Section'),
('ITO', '221027100000', 'Information & Communications Technology Section'),
('LEGAL', '202211060000', 'Legal Section'),
('LRMDS', '221115440000', 'Learning Resource Management Section'),
('OSDS', '20230403142138', 'Office of the Schools Division Superintendent'),
('PSDS', '221111450000', 'Public Schools District Supervisor'),
('RECORD', '221111500000', 'Records Section'),
('SGOD', '221111300000', 'Office of the Schools Governance & Operations Division Chief'),
('SUPPLY', '221111220000', 'Properties & Supply Section');

ALTER TABLE `tbl_div_section`
  ADD PRIMARY KEY (`Section_Code`);
COMMIT;