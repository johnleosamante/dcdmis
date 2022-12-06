<div class="tab-pane fade" id="work-experience">

  <a href="#myexperience" class="btn btn-primary" data-toggle="modal" style="float:right">Add</a>
  <h4>V. Work Experience (include private employee start from your recent work) description of duties should be indicated in then attached Work Experience sheet</h4>
  <div style="overflow-x:auto;">
    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
      <thead>
        <tr>
          <th width="20%" colspan="2">Inclusive Dates</th>
          <th width="10%" rowspan="2">Position Title</th>
          <th width="25%" rowspan="2">Department / Agency / Office / Company <br />
            (Write in full do not abbreviate)</th>
          <th width="10%" rowspan="2">Monthly Salary</th>
          <th width="15%" rowspan="2">Salary / job / Pay Grade (if applicable)& step (Format "00-0") Increment</th>
          <th width="10%" rowspan="2">Status of Appointment</th>
          <th width="10%" rowspan="2">Government service (Y/N)</th>
          <th width="7%" rowspan="2"></th>
        </tr>
        <tr>
          <th>From</th>
          <th>To</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $result4 = mysqli_query($con, "SELECT * FROM work_experience WHERE Emp_ID='" . $_SESSION['EmpID'] . "' ORDER BY work_experience.No Asc");
        while ($row4 = mysqli_fetch_array($result4)) {
          echo '<tr>
												<td style="text-align:center;">' . $row4['From'] . '</td>
												<td style="text-align:center;">' . $row4['To'] . '</td>
												<td style="text-align:center;">' . $row4['Position_Title'] . '</td>
												<td style="text-align:center;">' . $row4['Organization'] . '</td>
												<td style="text-align:center;">' . $row4['Monthly_Salary'] . '</td>
												<td style="text-align:center;">' . $row4['Salary_Grade'] . '</td>
												<td style="text-align:center;">' . $row4['Job_Status'] . '</td>
												<td style="text-align:center;">' . $row4['Goverment'] . '</td>
												
												<td style="text-align:center;">
													<a href="my_experience.php?id=' . urlencode(base64_encode($row4['No'])) . '" data-toggle="modal" data-target="#myfamily"> Edit</a><br/>		
													<a style="cursor:pointer;" onclick="delete_work(this.id)" id="' . $row4['No'] . '">Remove</a>
													
													  </td>
											
												</tr>';
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

<script>
  function delete_work(id) {
    if (confirm("Are you sure you want to deleted this row?")) {

      window.location.href = 'delete_work.php?id=' + id;
    }
  }
</script>

<!-- Modal for work experience-->
<div class="modal fade" id="myexperience" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="loginbox">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">V. WORK EXPERIENCE (include private employee start from your recent work) description of duties should be indicated in then attached Work Experience sheet
        </h4>

      </div>
      <div class="modal-body">
        <form enctype="multipart/form-data" method="post" role="form" action="">
          <div class="form-group">
            <div style="overflow-x:auto;">
              <table width="100%" class="table table-bordered">
                <tr>
                  <th style="text-align:center;" colspan="2">INCLUSIVE DATES</th>
                  <th style="text-align:center;" rowspan="2">Position Title</th>
                  <th style="text-align:center;" rowspan="2">Department / Agency / Office / Company <br />(Write in full do not abbreviate)</th>
                  <th style="text-align:center;" rowspan="2">Monthly Salary</th>
                  <th style="text-align:center;" rowspan="2">Salary / job / Pay Grade (if applicable) <br />& step (Format "00-0") Increment</th>
                  <th style="text-align:center;" rowspan="2">STATUS of <br />Appointment</th>
                  <th style="text-align:center;" rowspan="2">GOVERNMENT service (Y/N)</th>
                </tr>
                <tr>
                  <th style="text-align:center;">From</th>
                  <th style="text-align:center;">To</th>
                </tr>';

                <tr>
                  <th><input type="text" name="from" class="form-control" required></th>
                  <th><input type="text" name="to" class="form-control" required></th>
                  <th><input type="text" name="position" class="form-control" required></th>
                  <th><input type="text" name="organization" class="form-control" required></th>
                  <th><input type="text" name="monthly" class="form-control" required></th>
                  <th><input type="text" name="step" class="form-control" required></th>
                  <th><input type="text" name="status" class="form-control" required></th>
                  <th><input type="text" name="government" class="form-control" style="text-align:center;" required></th>
                </tr>

              </table>
            </div>
            <button type="submit" class="btn btn-primary" name="save_work" value="SAVE">ADD</button>
        </form>

      </div>
    </div>
  </div>
</div>
</div>

<!-- Modal for update Volunter-->
<div class="modal fade" id="myexpert" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="loginbox">

    <!-- Modal content-->
    <div class="modal-content">




    </div>
  </div>
</div>
<!--Update Other-->