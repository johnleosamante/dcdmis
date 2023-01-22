ALTER TABLE tbl_employee
 ADD Emp_CS_Others varchar(15) NOT NULL AFTER Emp_CS,
 ADD Emp_Dual_Citizenship varchar(20) NOT NULL AFTER Emp_Citizen,
 ADD Emp_Country varchar(50) NOT NULL AFTER Emp_Dual_Citizenship,
 ADD Emp_GSIS varchar(20) NOT NULL AFTER Emp_Blood_type,
 ADD Emp_PAGIBIG varchar(20) NOT NULL AFTER Emp_GSIS,
 ADD Emp_PHILHEALTH varchar(20) NOT NULL AFTER Emp_PAGIBIG,
 ADD Emp_SSS varchar(20) NOT NULL AFTER Emp_PHILHEALTH,
 ADD Emp_Res_Lot varchar(50) NOT NULL AFTER Emp_Sex,
 ADD Emp_Res_Street varchar(50) NOT NULL AFTER Emp_Res_Lot,
 ADD Emp_Res_Subdivision varchar(50) NOT NULL AFTER Emp_Res_Street,
 ADD Emp_Res_Barangay varchar(50) NOT NULL AFTER Emp_Res_Subdivision,
 ADD Emp_Res_City varchar(50) NOT NULL AFTER Emp_Res_Barangay,
 MODIFY Emp_Address varchar(50) NOT NULL,
 ADD Emp_Res_ZIP varchar(5) NOT NULL AFTER Emp_Address,
 ADD Emp_Per_Lot varchar(50) NOT NULL AFTER Emp_Res_ZIP,
 ADD Emp_Per_Street varchar(50) NOT NULL AFTER Emp_Per_Lot,
 ADD Emp_Per_Subdivision varchar(50) NOT NULL AFTER Emp_Per_Street,
 ADD Emp_Per_Barangay varchar(50) NOT NULL AFTER Emp_Per_Subdivision,
 ADD Emp_Per_City varchar(50) NOT NULL AFTER Emp_Per_Barangay,
 ADD Emp_Per_Province varchar(50) NOT NULL AFTER Emp_Per_City,
 ADD Emp_Per_ZIP varchar(5) NOT NULL AFTER Emp_Per_Province,
 ADD Emp_Telephone varchar(20) NOT NULL AFTER Emp_Per_ZIP,
 MODIFY EmpNo varchar(20) NOT NULL,
 MODIFY Emp_TIN varchar(20) NOT NULL
;

UPDATE tbl_employee SET Emp_Dual_Citizenship='N/A';