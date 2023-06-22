CREATE TABLE `tbl_div_section` (
  `Section_Code` varchar(15) NOT NULL DEFAULT '0',
  `Section_Incharge` varchar(50) DEFAULT NULL,
  `Section_Office` varchar(100) DEFAULT NULL
);

INSERT INTO `tbl_div_section` (`Section_Code`, `Section_Incharge`, `Section_Office`) VALUES
('ACC', '221110380000', 'Accounting Section'),
('ADM', '221110470000', 'Administrative Section'),
('ASD', '202211190000', 'Office of the Assistant Schools Division Superintendent'),
('BAC', '202211190000', 'Bidding & Awards Committee'),
('BUD', '221110470000', 'Budget Section'),
('CSH', '221111410000', 'Cash Section'),
('CID', '221111450000', 'Office of the Curriculum Implementation Division Chief'),
('EPS', '221111450000', 'Education Program Supervisor'),
('GSS', '221117390000', 'General Services Section'),
('HNS', '221116590000', 'Health & Nutrition Section'),
('PER', '221111180000', 'Personnel Section'),
('ICT', '221027100000', 'Information & Communications Technology Section'),
('LGL', '202211060000', 'Legal Section'),
('LRM', '221115440000', 'Learning Resource Management Section'),
('SDS', '20230403142138', 'Office of the Schools Division Superintendent'),
('PSD', '221111450000', 'Public Schools District Supervisor'),
('REC', '221111500000', 'Records Section'),
('SGO', '221111300000', 'Office of the Schools Governance & Operations Division Chief'),
('PSS', '221111220000', 'Properties & Supply Section');

ALTER TABLE `tbl_div_section` ADD PRIMARY KEY (`Section_Code`);