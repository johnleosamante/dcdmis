<?php
require_once('../includes/function.php');
require_once(root() . '/includes/string.php');
require_once(root() . '/includes/database/database.php');

function alterCivilService() {
  echo 'Altering Civil Service...<br>';
  nonQuery("ALTER TABLE `civil_service` ADD `isapplicabledate` BOOLEAN NOT NULL AFTER `Number_of_Hour`;");
  echo 'Completed...<br><br>';
}

function alterEducationalBackground() {
  echo 'Altering Educational Background...<br>';
  nonQuery("ALTER TABLE `educational_background` ADD `ispresent` BOOLEAN NOT NULL AFTER `To`;");
  echo 'Completed...<br><br>';
}

function alterSystemLogs() {
  echo 'Altering System Logs...<br>';
  nonQuery("ALTER TABLE `tbl_system_logs` ADD `target_id` VARCHAR(30) NOT NULL AFTER `Status`;");
  echo 'Completed...<br><br>';
}

function alterVoluntaryWork() {
  echo 'Altering Voluntary Work...<br>';
  nonQuery("ALTER TABLE `voluntary_work` ADD `ispresent` BOOLEAN NOT NULL AFTER `To`;");
  echo 'Completed...<br><br>';
}

function alterWorkExperience() {
  echo 'Altering Work Experience...<br>';
  nonQuery("ALTER TABLE `work_experience` ADD `ispresent` BOOLEAN NOT NULL AFTER `To`;");
  echo 'Completed...<br><br>';
}

function checkEmployeeStation() {
  echo 'Checking employee station...<br>';

  $activeEmployees = query("SELECT * FROM tbl_employee;");
  $no = 0;

  while ($active = fetchAssoc($activeEmployees)) {
    if (numRows(query("SELECT * FROM tbl_station WHERE Emp_ID='" . $active['Emp_ID'] . "';")) === 0) {
      echo ++$no . ' | ' . $active['Emp_ID'] . ' | ' . toName($active['Emp_LName'], $active['Emp_FName'], $active['Emp_MName'], $active['Emp_Extension']) . '<br>';
    }
  }

  echo '(' . $no . ') Completed...<br><br>';
}

function checkEmployeeAccount() {
  echo 'Checking employee account...<br>';

  $activeEmployees = query("SELECT * FROM tbl_employee;");
  $no = 0;

  while ($active = fetchAssoc($activeEmployees)) {
    if (numRows(query("SELECT * FROM tbl_teacher_account WHERE Teacher_TIN='" . $active['Emp_Email'] . "';")) === 0) {
      query("INSERT INTO tbl_teacher_account (`Teacher_TIN`, `Teacher_Password`) VALUES ('" . $active['Emp_Email'] . "', '" . hashPassword(generateStrongRandomPassword()) . "');");

      if (affectedRows()) {
        echo ++$no . ' | ' . $active['Emp_ID'] . ' | ' . toName($active['Emp_LName'], $active['Emp_FName'], $active['Emp_MName'], $active['Emp_Extension']) . '<br>';
      }
    }
  }

  echo '(' . $no . ') Completed...<br><br>';
}

function checkEmployeeStepIncrement() {
  echo 'Checking employee step increment...<br>';

  $activeEmployees = query("SELECT * FROM tbl_employee;");
  $no = 0;

  while ($active = fetchAssoc($activeEmployees)) {
    if (numRows(query("SELECT * FROM tbl_step_increment WHERE Emp_ID='" . $active['Emp_ID'] . "';")) === 0) {
      query("INSERT INTO tbl_step_increment (`Date_last_step`, `Step_No`, `No_of_year`, `Emp_ID`) VALUES ('1', '1', '0', '" . $active['Emp_ID'] . "');");

      if (affectedRows()) {
        echo ++$no . ' | ' . $active['Emp_ID'] . ' | ' . toName($active['Emp_LName'], $active['Emp_FName'], $active['Emp_MName'], $active['Emp_Extension']) . '<br>';
      }
    }
  }

  echo '(' . $no . ') Completed...<br><br>';
}

function checkEmployeeOtherInformation() {
  echo 'Checking employee other information...<br>';

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

  echo '(' . $no . ') Completed...<br><br>';
}

function checkEmployeePsipop() {
  echo 'Checking employee psipop...<br>';
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

  echo '(' . $no . ') Completed...<br><br>';
}

function checkEmployeeDeployment() {
  echo 'Checking employee deployment...<br>';

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

  echo '(' . $no . ') Completed...<br><br>';
}

function checkEmployeeFamily() {
  echo 'Checking employee family...<br>';

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

  echo '(' . $no . ') Completed...<br><br>';
}

function checkEmployeeValidId() {
  echo 'Checking employee valid id...<br>';

  $activeEmployees = query("SELECT * FROM `tbl_employee`;");
  $no = 0;

  while ($active = fetchAssoc($activeEmployees)) {
    if (numRows(query("SELECT * FROM tbl_valid_id WHERE Emp_ID='" . $active['Emp_ID'] . "';")) === 0) {
      query("INSERT INTO tbl_valid_id (`Government`, `ID_Number`, `Place_issued`, `Date_issued`, `Emp_ID`) VALUES ('', '', '', NOW(), '" . $active['Emp_ID'] . "');");

      if (affectedRows() === 1) {
        echo ++$no . ' | ' . $active['Emp_ID'] . ' | ' . toName($active['Emp_LName'], $active['Emp_FName'], $active['Emp_MName'], $active['Emp_Extension']) . '<br>';
      }
    }
  }

  echo '(' . $no . ') Completed...<br><br>';
}

function checkTeacherPassword() {
  echo 'Setting teacher password...<br>';

  $users = query("SELECT `username`, `password` FROM tbl_user WHERE `password` <> '';");
  $no = 0;

  while ($u = fetchAssoc($users)) {
    nonQuery("UPDATE tbl_teacher_account SET `Teacher_Password`='" . $u['password'] . "' WHERE `Teacher_TIN`='" . $u['username'] . "';");

    if (affectedRows() === 1) {
      echo ++$no . ' | ' . $u['username'] . '<br>';
    }
  }

  echo '(' . $no . ') Completed...<br><br>';
}

function setTransactionStatus() {
  echo 'Setting transaction status...<br>';

  $no = 0;
  nonQuery("UPDATE tbl_transactions SET `Status`='Unread' WHERE Trans_Stats NOT LIKE '%Complete%' OR Trans_Stats NOT LIKE '%Cancel%';");
  $no = affectedRows();
  nonQuery("UPDATE tbl_transactions SET `Status`='Read' WHERE Trans_Stats LIKE '%Complete%' OR Trans_Stats LIKE '%Cancel%';");
  $no = $no + affectedRows();

  echo '(' . $no . ') Completed...<br><br>';
}

function setTransactionLogStatus() {
  echo 'Setting transaction log status...<br>';

  nonQuery("UPDATE tbl_transactions_Log SET `Status`='Done';");

  echo '(' . affectedRows(). ') Completed...<br><br>';
}

function setLastTransactionLogStatus() {
  echo 'Setting last transaction log status...<br>';

  $transactions = query("SELECT * FROM tbl_transactions WHERE Trans_Stats NOT LIKE '%Complete%' OR Trans_Stats NOT LIKE '%Cancel%';");
  $no = 0;

  while ($t = fetchAssoc($transactions)) {
    $logs = query("SELECT * FROM tbl_transactions_log WHERE Transaction_code='" . $t['TransCode'] . "' ORDER BY Date_recieved DESC LIMIT 1;");
    $l = fetchAssoc($logs);
    nonQuery("UPDATE tbl_transactions_log SET `Status`='New' WHERE `No`='" . $l['No'] . "' AND Trans_status NOT LIKE '%Complete%' AND Trans_status NOT LIKE '%Cancel%';");

    if (affectedRows() === 1) {
      echo ++$no . ' | ' . $t['TransCode'] . ' | ' .$t['Title'] . '<br>';
    }
  }

  echo '(' . $no . ') Completed...<br><br>';
}

function setActivityStatus($value, $reference) {
  echo 'Setting activity status (' . $value . ')...<br>';

  nonQuery("UPDATE tbl_system_logs SET `Status`='{$value}' WHERE `Status`='{$reference}';");

  echo '(' . affectedRows() . ') Completed...<br><br>';
}

function setLoginTargetId() {
  echo 'Setting login target id...<br>';

  $logs = query("SELECT `Emp_ID` AS `id` FROM tbl_system_logs WHERE `Status`='Logged in';");
  $no = 0;

  while($log = fetchAssoc($logs)) {
    nonQuery("UPDATE tbl_system_logs SET `target_id`='" . $log['id'] . "' WHERE `Status`='Logged in' AND Emp_ID='" . $log['id'] . "';");
    if (affectedRows()) {
      ++$no;
    }
  }

  echo '(' . $no . ') Completed...<br><br>';
}

function setCreatedDocumentTargetId() {
  echo 'Setting created document target id...<br>';

  $logs = query("SELECT TransCode AS `id`, Date_time AS `datetime` FROM tbl_transactions;");
  $no = 0;

  while ($log = fetchAssoc($logs)) {
    nonQuery("UPDATE tbl_system_logs SET `target_id`='" . $log['id'] . "' WHERE `Status`='Created document' AND Time_Log='" . $log['datetime'] . "';");
    if (affectedRows()) {
      echo ++$no . ' | ' . $log['id'] . '<br>';
    }
  }

  echo '(' . $no . ') Completed...<br><br>';
}

function updateEducationalBackgroundLevel($value, $reference) {
  echo 'Updating educational background level (' . $value . ')...<br>';

  nonQuery("UPDATE `educational_background` SET `Level`='{$value}' WHERE `Level`='{$reference}';");

  echo '(' . affectedRows() . ') Completed...<br><br>';
}

function addUserPrivilege($id, $email, $station) {
  echo 'Adding user privilege (' . $email . ')...<br>';

  nonQuery("INSERT INTO tbl_user (`usercode`, `username`, `Station`) VALUES ('{$id}', '{$email}', '{$station}');");

  echo '(' . affectedRows() . ') Completed...<br><br>';
}

require_once(root() . '/includes/database/document.php');
require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/utility.php');

function addUserToTransaction() {
  $logs = query("SELECT TransCode AS `id`, Date_time AS `datetime` FROM tbl_transactions ORDER BY TransCode, Date_time;");
  $no = 0;

  while ($log = fetchAssoc($logs)) {
    $user = fetchAssoc(documentOrigin($log['id']))['user'];
    // nonQuery("UPDATE tbl_transactions SET `SchoolID`='$user' WHERE `TransCode`='" . $log['id'] . "' LIMIT 1;");
    // if (affectedRows()) {
      echo ++$no . ' | Code: ' . $log['id'] . ' | Created by: ' . userName($user) . ' (' . $user . ') | ' . $log['datetime'] . ' <br>';
    // } else {
    //   echo ++$no . ' | Code: ' . $log['id'] . ' | Created by: ' . userName($user) . ' not set.<br>';
    // }
  }
}

function setHeadToTransaction($stationId, $headId) {
  echo "Setting station [$stationId] and station head [" . userName($headId) . "]...<br>";
  nonQuery("UPDATE tbl_transactions SET `SchoolID`='{$headId}' WHERE TransCode LIKE '" . $stationId . "%';");
  echo affectedRows() . ' affected rows...<br>';
}

// alterCivilService();
// alterEducationalBackground();
// alterSystemLogs();
// alterVoluntaryWork();
// alterWorkExperience();

// checkEmployeeStation();
// checkEmployeeAccount();
// checkEmployeeStepIncrement();
// checkEmployeeOtherInformation();
// checkEmployeePsipop();
// checkEmployeeDeployment();
// checkEmployeeFamily();
// checkEmployeeValidId();
// checkTeacherPassword();

// setTransactionStatus();
// setTransactionLogStatus();
// setLastTransactionLogStatus();

// setActivityStatus('Logged in', 'Login');
// setActivityStatus('Created document', 'Transaction');
// setLoginTargetId();
// setCreatedDocumentTargetId();

// updateEducationalBackgroundLevel('Graduate Studies', 'Masteral');
// updateEducationalBackgroundLevel('Graduate Studies', 'Doctoral');
// updateEducationalBackgroundLevel('Secondary', 'High School');

// addUserPrivilege('221024040000', 'johnleo.samante@deped.gov.ph', 'HRMIS');
// addUserPrivilege('221024040000', 'johnleo.samante@deped.gov.ph', 'DMIS');
// addUserPrivilege('221024040000', 'johnleo.samante@deped.gov.ph', 'HRTDMS');

// addUserToTransaction();

// setHeadToTransaction('125962-', '221111570000');
// setHeadToTransaction('125963-', '221111160000');
// setHeadToTransaction('125965-', '221111080000');
// // setHeadToTransaction('125966-', ''); // LugdunganES
// setHeadToTransaction('125967-', '221111090000');
// setHeadToTransaction('125968-', '221111350000');
// setHeadToTransaction('125969-', '221111540000');
// // setHeadToTransaction('125970-', ''); // TurnoES
// setHeadToTransaction('125972-', '221111380000');
// setHeadToTransaction('125973-', '221111170000');
// setHeadToTransaction('125974-', '221111230000');
// setHeadToTransaction('125977-', '221111520000');
// setHeadToTransaction('125979-', '221111310000');
// setHeadToTransaction('125980-', '221111020000');
// setHeadToTransaction('125982-', '221111000000');
// setHeadToTransaction('125983-', '221111240000');
// setHeadToTransaction('125984-', '221111060000');
// setHeadToTransaction('125986-', '221111360000');
// // setHeadToTransaction('125987', ''); // DiwanES
// setHeadToTransaction('125989-', '221111030000');
// setHeadToTransaction('125990-', '221111070000');
// setHeadToTransaction('125991-', '221111370000');
// setHeadToTransaction('125992-', '221111470000');
// setHeadToTransaction('125993-', '221111590000');
// setHeadToTransaction('125994-', '221111530000');
// setHeadToTransaction('125996-', '221111420000');
// setHeadToTransaction('125997-', '221111460000');
// setHeadToTransaction('125999-', '221111150000');
// // setHeadToTransaction('197501-', '') // DSPEDC
// setHeadToTransaction('303885-', '221111330000');
// setHeadToTransaction('303886-', '221111140000');
// setHeadToTransaction('303887-', '221111490000');
// setHeadToTransaction('303888-', '221111320000');
// setHeadToTransaction('303890-', '221111040000');
// setHeadToTransaction('303891-', '221111100000');
// setHeadToTransaction('303892-', '221111010000');
// setHeadToTransaction('303893-', '221111280000');
// setHeadToTransaction('3038931-', '221111280000');
// setHeadToTransaction('3038932-', '221111580000');
// setHeadToTransaction('306189-', '221111580000');
// setHeadToTransaction('305638-', '221111190000');
// setHeadToTransaction('500046-', '221111050000');
// setHeadToTransaction('500242-', '20221217141601');
// setHeadToTransaction('501111-', '221111430000');
// // add sections
// setHeadToTransaction('ACC-', '20230823101248');
// // setHeadToTransaction('ACCOUNTING-', '');
// setHeadToTransaction('ADM-', '221110470000');
// setHeadToTransaction('ADMIN-', '221110470000');
// setHeadToTransaction('ADS', '202211190000');
// setHeadToTransaction('ASDS-', '202211190000');
// setHeadToTransaction('BAC-', '202211190000');
// setHeadToTransaction('BUD-', '221110470000');
// setHeadToTransaction('BUDGET-', '221110470000');
// setHeadToTransaction('CSH-', '221111410000');
// setHeadToTransaction('CASHIER-', '221111410000');
// setHeadToTransaction('CID-', '221111450000');
// setHeadToTransaction('PER-', '221111180000');
// setHeadToTransaction('HRMO-', '221111180000');
// setHeadToTransaction('ITO-', '221027100000');
// setHeadToTransaction('ICT-', '221027100000');
// setHeadToTransaction('LRM-', '221115440000');
// setHeadToTransaction('LRMS-', '221115440000');
// setHeadToTransaction('SDS-', '20230403142138');
// // setHeadToTransaction('OSDS-', '');
// setHeadToTransaction('PHYSICAL-', '221117390000');
// setHeadToTransaction('PSDS-', '221111450000');
// setHeadToTransaction('PDS-', '221111450000');
// setHeadToTransaction('PSS-', '221111220000');
// setHeadToTransaction('SUPPLY-', '221111220000');
// setHeadToTransaction('REC-', '221111500000');
// setHeadToTransaction('RECORD-', '221111500000');
// setHeadToTransaction('SGD-', '221111300000');
// setHeadToTransaction('SGOD-', '221111300000');
?>