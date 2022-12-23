<?php
# _includes_/database/employee.php

function GetEmployeeName($lastName, $firstName, $middleName, $nameExtension) {
  return DBQuery("SELECT * FROM tbl_employee WHERE Emp_LName='$lastName' AND Emp_FName='$firstName' AND Emp_MName='$middleName' AND Emp_Extension='$nameExtension' LIMIT 1;");
}

function InsertEmployee($employeeID, $lastName, $firstName, $middleName, $nameExtension, $birthMonth, $birthDay, $birthYear, $birthPlace, $sex, $address, $civilStatus, $citizenship, $height, $weight, $bloodType, $contactNo, $email, $picture, $tin, $status, $dbpAccount, $course, $employeeNumber) {
  DBNonQuery("INSERT INTO tbl_employee VALUES ('$employeeID', '$lastName', '$firstName', '$middleName', '$nameExtension', '$birthMonth', '$birthDay', '$birthYear', '$birthPlace', '$sex', '$address', '$civilStatus', '$citizenship', '$height', '$weight', '$bloodType', '$contactNo', '$email', '$picture', '$tin', '$status', '$dbpAccount', '$course', '$employeeNumber');");
}
?>