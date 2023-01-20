<?php
# _includes_/database/employee.php

function GetEmployeeName($lastName, $firstName, $middleName, $nameExtension) {
  return DBQuery("SELECT * FROM tbl_employee WHERE Emp_LName='$lastName' AND Emp_FName='$firstName' AND Emp_MName='$middleName' AND Emp_Extension='$nameExtension' LIMIT 1;");
}

function InsertEmployee($employeeID, $lastName, $firstName, $middleName, $nameExtension, $birthMonth, $birthDay, $birthYear, $birthPlace, $sex, $address, $civilStatus, $citizenship, $height, $weight, $bloodType, $contactNo, $email, $picture, $tin, $status, $dbpAccount, $course, $employeeNumber) {
  DBNonQuery("INSERT INTO tbl_employee (Emp_ID, Emp_LName, Emp_FName, Emp_MName, Emp_Extenstion, Emp_Month, Emp_Day, Emp_Year, Emp_place_of_birth, Emp_Sex, Emp_Address, Emp_CS, Emp_Citizen, Emp_Height, Emp_Weight, Emp_Blood_type, Emp_Cell_No, Emp_Email, Picture, Emp_TIN, Emp_Status, Emp_DBP_Account, Course, EmpNo) VALUES ('$employeeID', '$lastName', '$firstName', '$middleName', '$nameExtension', '$birthMonth', '$birthDay', '$birthYear', '$birthPlace', '$sex', '$address', '$civilStatus', '$citizenship', '$height', '$weight', '$bloodType', '$contactNo', '$email', '$picture', '$tin', '$status', '$dbpAccount', '$course', '$employeeNumber');");
}
?>