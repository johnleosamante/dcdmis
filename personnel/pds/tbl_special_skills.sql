CREATE TABLE tbl_special_skills AS SELECT `No`, `Special_Skills`, `Emp_ID` FROM other_information WHERE Special_Skills <> 'N/A' OR Special_Skills <> '';

ALTER TABLE tbl_special_skills
  MODIFY `No` INT(11) NOT NULL AUTO_INCREMENT,
  ADD PRIMARY KEY (`No`);
;