<?php
// export/schools.php
if (!isset($_GET['v'])) {
  return;
}

require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/utility.php');
?>

<table>
  <thead>
    <tr>
      <th rowspan="3">#</th>
      <th rowspan="3">School ID</th>
      <th rowspan="3">School Name</th>
      <th rowspan="3">District</th>
      <th rowspan="3">Category</th>
      <th rowspan="3">Head of Office</th>
      <th colspan="9">Personnel</th>
    </tr>
    <tr>
      <th colspan="4">Male</th>
      <th colspan="4">Female</th>
      <th rowspan="2">Total</th>
    </tr>
    <tr>
      <th>Teaching</th>
      <th>Teaching-Related</th>
      <th>Non-Teaching</th>
      <th>Total</th>
      <th>Teaching</th>
      <th>Teaching-Related</th>
      <th>Non-Teaching</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $i = 1;
    $query = schoolEmployeeCount();
    while ($row = fetchArray($query)) : ?>
      <tr>
        <td><?php echo $i++; ?></td>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo strtoupper($row['name']); ?></td>
        <td><?php echo strtoupper($row['district']); ?></td>
        <td><?php echo strtoupper($row['category']); ?></td>
        <td><?php echo strtoupper(userName($row['head'])); ?></td>
        <td><?php echo $row['tmale']; ?></td>
        <td><?php echo $row['trmale']; ?></td>
        <td><?php echo $row['ntmale']; ?></td>
        <td><strong><?php echo $row['male']; ?></strong></td>
        <td><?php echo $row['tfemale']; ?></td>
        <td><?php echo $row['trfemale']; ?></td>
        <td><?php echo $row['ntfemale']; ?></td>
        <td><strong><?php echo $row['female']; ?></strong></td>
        <td><strong><?php echo $row['total']; ?></strong></td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>