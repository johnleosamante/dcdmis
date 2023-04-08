ALTER TABLE `tbl_div_section` CHANGE `Section_Code` `Section_Code` VARCHAR(15) NOT NULL DEFAULT '0';
ALTER TABLE `tbl_div_section` CHANGE `Section_Office` `Section_Office` VARCHAR(100);

INSERT INTO `tbl_div_section` (`Section_Code`, `Section_Office`) VALUES 
('OSDS', 'Office of the Schools Division Superintendent'),
('ASDS', 'Office of the Assistant Schools Division Superintendent'),
('ICT', 'Information & Communications Technology Section'),
('CID', 'Curriculum Implementation Division'),
('SGOD', 'Schools Governance & Operations Division'),
('LEGAL', 'Legal Section'),
('HRMO', 'Personnel Section'),
('ACCOUNTING', 'Accounting Section'),
('ADMIN', 'Administrative Section'),
('CASH', 'Cash Section'),
('RECORD', 'Records Section'),
('LRMS', 'Learning Resource Manangement Section'),
('BUDGET', 'Budget Section'),
('BAC', 'Bidding & Awards Committee'),
('SUPPLY', 'Properties & Supply Section'),
('PHYSICAL', 'General Services Section'),
('HEALTH', 'Health & Nutrition Section');