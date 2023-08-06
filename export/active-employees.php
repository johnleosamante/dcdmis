<table>
  <tr>
    <td>#</td>
    <td>PhilHealth ID</td>
    <td>PAGIBIG ID</td>
    <td>Last Name</td>
    <td>First Name</td>
    <td>Middle Name</td>
    <td>Ext Name</td>
    <td>Sex</td>
    <td>Date of Birth</td>
    <td>Contact No.</td>
    <td>Email Address</td>
    <td>School/Office</td>
    <td>Residential Address</td>
  </tr>
  <?php
  $i = 1;
  $rows = query("SELECT tbl_employee.Emp_PHILHEALTH AS philhealth, tbl_employee.Emp_PAGIBIG AS pagibig, tbl_employee.Emp_LName AS lname, tbl_employee.Emp_FName AS fname, tbl_employee.Emp_MName AS mname, tbl_employee.Emp_Extension AS ext, tbl_employee.Emp_Sex AS sex, tbl_employee.Emp_Month AS bmonth, tbl_employee.Emp_Day AS bday, tbl_employee.Emp_Year AS byear, tbl_employee.Emp_Cell_No AS contact, tbl_employee.Emp_Email AS email, tbl_school.Abraviate AS school, tbl_employee.Emp_Res_Street AS street, tbl_employee.Emp_Res_Subdivision AS subdivision, tbl_employee.Emp_Res_Barangay AS barangay, tbl_employee. Emp_Res_City AS city, tbl_employee.Emp_Address AS province FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID=tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID WHERE Emp_Status='Active' ORDER BY tbl_school.Abraviate, tbl_employee.Emp_LName;");
  foreach ($rows as $row) : ?>
    <tr>
      <td><?php echo $i++; ?></td>
      <td><?php echo $row['philhealth']; ?></td>
      <td><?php echo $row['pagibig']; ?></td>
      <td><?php echo $row['lname']; ?></td>
      <td><?php echo $row['fname']; ?></td>
      <td><?php echo $row['mname']; ?></td>
      <td><?php echo $row['ext']; ?></td>
      <td><?php echo $row['sex']; ?></td>
      <td><?php echo $row['byear'] . '-' . $row['bmonth'] . '-' . $row['bday']; ?></td>
      <td><?php echo $row['contact']; ?></td>
      <td><?php echo $row['email']; ?></td>
      <td><?php echo $row['school']; ?></td>
      <td><?php echo toAddress('', $row['street'], $row['subdivision'], $row['barangay'], $row['city'], $row['province']) ?></td>
    </tr>
  <?php endforeach; ?>
</table>