ALTER TABLE `tbl_division` CHANGE `Div_Code` `Div_Code` VARCHAR(4) NOT NULL;

INSERT INTO `tbl_division` (`Div_Code`, `Division_Name`) VALUES ('OSDS', 'Office of the Schools Division Superintendent'), ('CID', 'Curriculum Implementation Division'), ('SGOD', 'Schools Governance & Operations Division');