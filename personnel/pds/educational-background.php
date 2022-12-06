<div class="tab-pane fade" id="educational-background">
  <a href="#myeb" class="btn btn-primary" data-toggle="modal" style="float:right">Add</a>
  <h4>III. Educational Background</h4>
  <div style="overflow-x:auto;width:100%;">
    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
      <thead>
        <tr>
          <th width="10%" rowspan="2">Level</th>
          <th width="20%" rowspan="2">Name of School <br /> (Write in Full)</th>
          <th width="20%" rowspan="2">Basic Education / Degree / Course <br /> (Write in Full)</th>
          <th width="15%" colspan="2">Period of Attendance</th>
          <th width="10%" rowspan="2">Highest Level / Units Earned <br /> (If not Graduated)</th>
          <th width="10%" rowspan="2">Year Graduated</th>
          <th width="10%" rowspan="2">SCHOLARSHIP/ ACADEMIC HONORS RECEIVED</th>
          <th width="7%" rowspan="2"></th>
        </tr>
        <tr>
          <th>From</th>
          <th>To</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $result2 = mysqli_query($con, "SELECT * FROM educational_background WHERE Emp_ID='" . $_SESSION['EmpID'] . "'");
        while ($row2 = mysqli_fetch_array($result2)) {
          echo '<tr><td style="text-align:center;">' . $row2['Level'] . '</td>
													  <td style="text-align:center;">' . $row2['Name_of_School'] . '</td>
													  <td style="text-align:center;">' . $row2['Course'] . '</td>
													  <td style="text-align:center;">' . $row2['From'] . '</td>
													  <td style="text-align:center;">' . $row2['To'] . '</td>
													  <td style="text-align:center;">' . $row2['Highest_Level'] . '</td>
													  <td style="text-align:center;">' . $row2['Year_Graduated'] . '</td>
													  <td style="text-align:center;">' . $row2['Honor_Recieved'] . '</td>
													  <td style="text-align:center;">
																	<a href="my_educate.php?id=' . urlencode(base64_encode($row2['No'])) . '" data-toggle="modal" data-target="#myfamily">Edit</a><br/>
																
																	<a style="cursor:pointer;" id="' . $row2['No'] . '" onclick="delete_educ(this.id)">Remove</a>
																
													  </td>
													  
												  </tr>';
        }
        ?>

      </tbody>
    </table>
  </div>
</div>

<script>
  function delete_educ(id) {
    if (confirm("Are you sure you want to deleted this row?")) {

      window.location.href = 'delete_educ.php?id=' + id;
    }
  }
</script>

<!-- Modal for Educational Background-->
<div class="modal fade" id="myeb" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="loginbox">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">III. EDUCATIONAL BACKGROUND </h4>

      </div>
      <div class="modal-body">
        <form enctype="multipart/form-data" method="post" role="form" action="">
          <div class="form-group">
            <div style="overflow-x:auto;">
              <table width="100%" class="table table-bordered">
                <tr>
                  <th rowspan="2">LEVEL</th>
                  <th rowspan="2">NAME OF SCHOOL <br />(Write in full)</th>
                  <th rowspan="2">BASIC EDUCATION / DEGREE / COURSE<br />(Write in full)</th>
                  <th colspan="2">PERIOD OF ATTENDANCE</th>
                  <th rowspan="2">HIGHEST LEVEL /<br />UNITS EARNED<br />(if not graduated)</th>
                  <th rowspan="2">YEAR GRADUATED</th>
                  <th rowspan="2">SCHOLARSHIP/ ACADEMIC HONORS RECEIVED</th>
                </tr>
                <tr>
                  <th>FROM</th>
                  <th>TO</th>
                </tr>
                <tr>
                  <th>
                    <select name="level" id="level" class="form-control" required>
                      <option value="">--Select--</option>
                      <option value="Doctoral">Doctoral</option>
                      <option value="Masteral">Masteral</option>
                      <option value="Vocational">Vocational</option>
                      <option value="College">College</option>
                      <option value="High School">High School</option>
                      <option value="Elementary">Elementary</option>
                    </select>
                  </th>
                  <th><input type="text" name="school" class="form-control" required></th>
                  <th><input type="text" name="education" class="form-control" required></th>
                  <th><input type="text" name="from" class="form-control" required></th>
                  <th><input type="text" name="to" class="form-control" required></th>
                  <th>
                    <select name="unit" class="form-control" required>
                      <Option value="">--Select--</option>
                      <Option value="3">3</option>
                      <Option value="6">6</option>
                      <Option value="9">9</option>
                      <Option value="12">12</option>
                      <Option value="15">15</option>
                      <Option value="18">18</option>
                      <Option value="21">21</option>
                      <Option value="24">24</option>
                      <Option value="27">27</option>
                      <Option value="30">30</option>
                      <Option value="GRADUATED">GRADUATED</option>
                    </select>
                  </th>
                  <th><input type="text" name="year" class="form-control" required></th>
                  <th><input type="text" name="honor" class="form-control" required></th>
                </tr>
              </table>
            </div>
          </div>
          <button type="submit" class="btn btn-primary" name="sub_educ" value="SAVE">ADD</button>
        </form>

      </div>
    </div>
  </div>
</div>

<!-- Modal for update Volunter-->
<div class="modal fade" id="myeduc" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="loginbox">

    <!-- Modal content-->
    <div class="modal-content">




    </div>
  </div>
</div>
<!--Update Other-->