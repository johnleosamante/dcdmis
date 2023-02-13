CREATE TABLE tbl_membership AS SELECT `No`, `Organization`, `Emp_ID` FROM other_information WHERE Organization <> 'N/A' AND Organization <> '' AND Organization <> 'None';

ALTER TABLE tbl_recognition
  MODIFY `No` INT(11) NOT NULL AUTO_INCREMENT,
  ADD PRIMARY KEY (`No`);
;