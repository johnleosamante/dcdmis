<?php // export/retirable-employees.php ?>
<table>
  <tr>
    <td>#</td>
    <td>School/Office</td>
    <td>Position</td>
    <td>Employee ID</td>
    <td>Last Name</td>
    <td>First Name</td>
    <td>Middle Name</td>
    <td>Ext Name</td>
    <td>Sex</td>
    <td>Date of Birth</td>
    <td>Age</td>
    <td>GSIS CRN No.</td>
    <td>GSIS BP No.</td>
    <td>PAGIBIG ID No.</td>
    <td>PhilHealth ID No.</td>
    <td>SSS No.</td>
    <td>TIN No.</td>
    <td>Contact No.</td>
    <td>Email Address</td>
    <td>Residential Address</td>
  </tr>
  <?php
  $i = 1;
  $rows = query("SELECT * FROM (SELECT tbl_employee.EmpNo AS id, tbl_employee.Emp_LName AS lname, tbl_employee.Emp_FName AS fname, tbl_employee.Emp_MName AS mname, tbl_employee.Emp_Extension AS ext, tbl_employee.Emp_Sex AS sex, tbl_employee.Emp_Month AS `bmonth`, tbl_employee.Emp_Day AS `bday`, tbl_employee.Emp_Year AS `byear`, YEAR(CURRENT_DATE) - CONVERT(tbl_employee.Emp_Year, DECIMAL) AS year_age, tbl_employee.Emp_GSIS AS crn, tbl_employee.Emp_GSIS_BP AS bp, tbl_employee.Emp_PAGIBIG AS pagibig, tbl_employee.Emp_PHILHEALTH AS philhealth, tbl_employee.Emp_SSS AS sss, tbl_employee.Emp_TIN AS tin, tbl_employee.Emp_Cell_No AS contact, tbl_employee.Emp_Email AS email, tbl_job.Job_description AS position, tbl_school.SchoolName AS school, tbl_employee.Emp_Res_Street AS street, tbl_employee.Emp_Res_Subdivision AS subdivision, tbl_employee.Emp_Res_Barangay AS barangay, tbl_employee. Emp_Res_City AS city, tbl_employee.Emp_Address AS province FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID=tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code WHERE Emp_Status='Active') AS retirables WHERE year_age >= 60 ORDER BY school, lname;");
  foreach ($rows as $row) : ?>
    <tr>
      <td><?php echo $i++; ?></td>
      <td><?php echo strtoupper($row['school']); ?></td>
      <td><?php echo strtoupper($row['position']); ?></td>
      <td><?php echo $row['id']; ?></td>
      <td><?php echo strtoupper($row['lname']); ?></td>
      <td><?php echo strtoupper($row['fname']); ?></td>
      <td><?php echo strtoupper($row['mname']); ?></td>
      <td><?php echo strtoupper($row['ext']); ?></td>
      <td><?php echo strtoupper($row['sex'])[0]; ?></td>
      <td><?php echo $row['byear'] . '-' . $row['bmonth'] . '-' . $row['bday']; ?></td>
      <td><?php echo getAge($row['byear'], $row['bmonth'], $row['bday']); ?></td>
      </td>
      <td><?php echo $row['crn']; ?></td>
      <td><?php echo $row['bp']; ?></td>
      <td><?php echo $row['pagibig']; ?></td>
      <td><?php echo $row['philhealth']; ?></td>
      <td><?php echo $row['sss']; ?></td>
      <td><?php echo $row['tin']; ?></td>
      <td><?php echo $row['contact']; ?></td>
      <td><?php echo strtolower($row['email']); ?></td>
      <td><?php echo strtoupper(toAddress('', $row['street'], $row['subdivision'], $row['barangay'], $row['city'], $row['province'])); ?></td>
    </tr>
  <?php endforeach; ?>
</table>