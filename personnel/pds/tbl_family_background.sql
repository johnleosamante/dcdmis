CREATE TABLE tbl_family_background (
  Emp_ID varchar(30) NOT NULL,
  SpouseLast varchar(50) NOT NULL,
  SpouseFirst varchar(50) NOT NULL,
  SpouseExtension varchar(5) NOT NULL,
  SpouseMiddle varchar(50) NOT NULL,
  SpouseOccupation varchar(50) NOT NULL,
  SpouseBusiness varchar(100) NOT NULL,
  SpouseBusinessAddress varchar(100) NOT NULL,
  SpouseTelephone varchar(20) NOT NULL,
  FatherLast varchar(50) NOT NULL,
  FatherFirst varchar(50) NOT NULL,
  FatherExtension varchar(5) NOT NULL,
  FatherMiddle varchar(50) NOT NULL,
  MotherLast varchar(50) NOT NULL,
  MotherFirst varchar(50) NOT NULL,
  MotherMiddle varchar(50) NOT NULL,
  PRIMARY KEY (Emp_ID)
);

ALTER TABLE family_background
 ADD Name_Extension varchar(5) NOT NULL AFTER First_Name
;