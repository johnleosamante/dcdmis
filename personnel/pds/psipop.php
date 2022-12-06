<div class="tab-pane fade" id="psipop">
  <div class="col-lg-6">
    <form enctype="multipart/form-data" method="post" role="form" action="">
      <?php
      $mypsipop = mysqli_query($con, "SELECT * FROM psipop INNER JOIN tbl_station ON psipop.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code WHERE psipop.Emp_ID='" . $_SESSION['EmpID'] . "'");
      $rowpsip = mysqli_fetch_assoc($mypsipop);

      echo '<label>Item Number:</label>
								   <input type="text" name="item_number" class="form-control" value="' . $rowpsip['Item_Number'] . '" required>
								   <label>Date of Latest Appointment:</label>
								   <input type="date" name="DOA" class="form-control" value="' . $rowpsip['Date_promoted'] . '" required>
									<label>Step Number:</label>
								   <input type="number" name="SN" class="form-control" value="' . $rowpsip['Step'] . '" required>
								   <label>Position:</label>
								   <select  name="position" class="form-control" required>
								   <option value="' . $rowpsip['Job_code'] . '">' . $rowpsip['Job_description'] . '</option>';

      $mypost = mysqli_query($con, "SELECT * FROM tbl_job");
      while ($rowpost = mysqli_fetch_array($mypost)) {
        echo '<option value="' . $rowpost['Job_code'] . '">' . $rowpost['Job_description'] . '</option>';
      }
      echo ' </select>
								 <label>Job Status</label>
								 <select name="jobstatus" class="form-control" required>
								   <option value="' . $rowpsip['Job_status'] . '">' . $rowpsip['Job_status'] . '</option>
								   <option value="Permanent">Permanent</option>
								   <option value="Provisional">Provisional</option>
								   <option value="Job Order">Job Order</option>
								   <option value="City Paid">City Paid</option>
								 </select>
								 <label>Elegibility</label>
								 <select name="elegibility" class="form-control" required>
								   <option value="' . $rowpsip['Elegibility'] . '">' . $rowpsip['Elegibility'] . '</option>
								   <option value="LET">LET</option>
								   <option value="BLET">BLET</option>
								   <option value="CSC">CSC</option>
								 </select>';
      ?>

      <hr />
      <input type="submit" name="save_psipop" value="SAVE" class="btn btn-primary">
    </form>
  </div>
</div>

<script>
  function delete_reference(id) {
    if (confirm("Are you sure you want to deleted this row?")) {

      window.location.href = 'delete_reference.php?id=' + id;
    }
  }
</script>