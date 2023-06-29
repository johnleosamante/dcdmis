<?php
require_once('../includes/function.php');
require_once(root() . '/includes/string.php');
require_once(root() . '/includes/database/database.php');

function checkEmployeeStation() {
  $activeEmployees = query("SELECT * FROM tbl_employee;");
  $no = 0;

  while ($active = fetchAssoc($activeEmployees)) {
    if (numRows(query("SELECT * FROM tbl_station WHERE Emp_ID='" . $active['Emp_ID'] . "';")) === 0) {
      echo ++$no . ' | ' . $active['Emp_ID'] . ' | ' . toName($active['Emp_LName'], $active['Emp_FName'], $active['Emp_MName'], $active['Emp_Extension']) . '<br>';
    }
  }
}

function checkEmployeeAccount() {
  $activeEmployees = query("SELECT * FROM tbl_employee;");
  $no = 0;

  while ($active = fetchAssoc($activeEmployees)) {
    if (numRows(query("SELECT * FROM tbl_teacher_account WHERE Teacher_TIN='" . $active['Emp_Email'] . "';")) === 0) {
      query("INSERT INTO tbl_teacher_account (`Teacher_TIN`, `Teacher_Password`) VALUES ('" . $active['Emp_Email'] . "', '" . hashPassword(generateStrongRandomPassword()) . "');");

      if (affectedRows() === 1) {
        echo ++$no . ' | ' . $active['Emp_ID'] . ' | ' . toName($active['Emp_LName'], $active['Emp_FName'], $active['Emp_MName'], $active['Emp_Extension']) . '<br>';
      }
    }
  }
}

function checkEmployeeStepIncrement() {
  $activeEmployees = query("SELECT * FROM tbl_employee;");
  $no = 0;

  while ($active = fetchAssoc($activeEmployees)) {
    if (numRows(query("SELECT * FROM tbl_step_increment WHERE Emp_ID='" . $active['Emp_ID'] . "';")) === 0) {
      query("INSERT INTO tbl_step_increment (`Date_last_step`, `Step_No`, `No_of_year`, `Emp_ID`) VALUES ('1', '1', '0', '" . $active['Emp_ID'] . "');");

      if (affectedRows() === 1) {
        echo ++$no . ' | ' . $active['Emp_ID'] . ' | ' . toName($active['Emp_LName'], $active['Emp_FName'], $active['Emp_MName'], $active['Emp_Extension']) . '<br>';
      }
    }
  }
}

function checkEmployeeOtherInformation() {
  $activeEmployees = query("SELECT * FROM tbl_employee;");
  $no = 0;

  while ($active = fetchAssoc($activeEmployees)) {
    if (numRows(query("SELECT * FROM tbl_other_information WHERE Emp_ID='" . $active['Emp_ID'] . "';")) === 0) {
      query("INSERT INTO tbl_other_information (`Emp_ID`) VALUES ('" . $active['Emp_ID'] . "');");

      if (affectedRows() === 1) {
        echo ++$no . ' | ' . $active['Emp_ID'] . ' | ' . toName($active['Emp_LName'], $active['Emp_FName'], $active['Emp_MName'], $active['Emp_Extension']) . '<br>';
      }
    }
  }
}

function checkEmployeePsipop() {
  $activeEmployees = query("SELECT * FROM tbl_employee;");
  $no = 0;

  while ($active = fetchAssoc($activeEmployees)) {
    if (numRows(query("SELECT * FROM psipop WHERE Emp_ID='" . $active['Emp_ID'] . "';")) === 0) {
      query("INSERT INTO psipop (`Step`, `Job_status`, `Emp_ID`) VALUES ('1', 'Permanent', '" . $active['Emp_ID'] . "');");

      if (affectedRows() === 1) {
        echo ++$no . ' | ' . $active['Emp_ID'] . ' | ' . toName($active['Emp_LName'], $active['Emp_FName'], $active['Emp_MName'], $active['Emp_Extension']) . '<br>';
      }
    }
  }
}

function checkEmployeeDeployment() {
  $activeEmployees = query("SELECT tbl_employee.Emp_ID, tbl_employee.Emp_LName, tbl_employee.Emp_FName, tbl_employee.Emp_MName, tbl_employee.Emp_Extension, tbl_station.Emp_Station, tbl_station.Emp_Position FROM `tbl_employee` INNER JOIN `tbl_station` ON tbl_employee.Emp_ID = tbl_station.Emp_ID;");
  $no = 0;

  while ($active = fetchAssoc($activeEmployees)) {
    if (numRows(query("SELECT * FROM tbl_deployment_history WHERE Emp_ID='" . $active['Emp_ID'] . "';")) === 0) {
      query("INSERT INTO tbl_deployment_history (`station_assign`, `position_assign`, `No_of_years`, `StepNo`, `Emp_ID`) VALUES ('" . $active['Emp_Station'] . "', '" . $active['Emp_Position'] . "', '0', '1', '" . $active['Emp_ID'] . "');");

      if (affectedRows() === 1) {
        echo ++$no . ' | ' . $active['Emp_ID'] . ' | ' . toName($active['Emp_LName'], $active['Emp_FName'], $active['Emp_MName'], $active['Emp_Extension']) . '<br>';
      }
    }
  }
}

function checkEmployeeFamily() {
  $activeEmployees = query("SELECT * FROM `tbl_employee`;");
  $no = 0;

  while ($active = fetchAssoc($activeEmployees)) {
    if (numRows(query("SELECT * FROM tbl_family_background WHERE Emp_ID='" . $active['Emp_ID'] . "';")) === 0) {
      query("INSERT INTO tbl_family_background (`Emp_ID`) VALUES ('" . $active['Emp_ID'] . "');");

      if (affectedRows() === 1) {
        echo ++$no . ' | ' . $active['Emp_ID'] . ' | ' . toName($active['Emp_LName'], $active['Emp_FName'], $active['Emp_MName'], $active['Emp_Extension']) . '<br>';
      }
    }
  }
}

//checkEmployeeStation();
//checkEmployeeAccount();
//checkEmployeeStepIncrement();
//checkEmployeeOtherInformation();
//checkEmployeePsipop();
//checkEmployeeDeployment();
//checkEmployeeFamily();
?>