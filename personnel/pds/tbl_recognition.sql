CREATE TABLE tbl_recognition AS SELECT `No`, `Recognation` AS `Recognition`, `Emp_ID` FROM other_information WHERE Recognation <> 'N/A' AND Recognation <> '' AND Recognation <> 'None';

ALTER TABLE tbl_recognition
  MODIFY `No` INT(11) NOT NULL AUTO_INCREMENT,
  ADD PRIMARY KEY (`No`);
;