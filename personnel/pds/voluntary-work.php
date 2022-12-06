<div class="tab-pane fade" id="voluntary-work">
  <a href="#Myvoluntary" class="btn btn-primary" data-toggle="modal" style="float:right">Add</a>
  <h4>VI. Voluntary Work or Involvement in Civic / Non-Government / People / Voluntary Organization</h4>
  <div style="overflow-x:auto;">
    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
      <thead>
        <tr>
          <th width="30%" rowspan="2">Name & address of organization <br />(write in full)</th>
          <th width="10%" colspan="2">Inclusive Dates <br />(mm/dd/yyyy)</th>
          <th width="10%" rowspan="2">Number of hours</th>
          <th width="30%" rowspan="2">Position / Nature of work</th>
          <th width="7%" rowspan="2"></th>
        </tr>
        <tr>
          <th>From</th>
          <th>To</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $result5 = mysqli_query($con, "SELECT * FROM voluntary_work WHERE Emp_ID='" . $_SESSION['EmpID'] . "'");
        while ($row5 = mysqli_fetch_array($result5)) {
          echo '<tr>
													<td style="text-align:center;">' . $row5['Name_of_Organization'] . '</td>
													<td style="text-align:center;">' . $row5['From'] . '</td>
													<td style="text-align:center;">' . $row5['To'] . '</td>
													<td style="text-align:center;">' . $row5['Number_of_Hour'] . '</td>
													<td style="text-align:center;">' . $row5['Position'] . '</td>
													 <td style="text-align:center;">
															<a href="my_volunter.php?id=' . urlencode(base64_encode($row5['No'])) . '" data-toggle="modal" data-target="#myfamily">Edit</a><br/>
																
															<a style="cursor:pointer;" onclick="delete_volunter(this.id)" id="' . $row5['No'] . '">Remove</a>
													
													  </td>

												 </tr>';
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

<script>
  function delete_volunter(id) {
    if (confirm("Are you sure you want to deleted this row?")) {

      window.location.href = 'delete_volunter.php?id=' + id;
    }
  }
</script>

<!-- Modal for Voluntary Work-->
<div class="modal fade" id="Myvoluntary" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="loginbox">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">VI. VOLUNTARY WORK OR INVOLVEMENT IN CIVIC / NON-GOVERNMENT / PEOPLE / VOLUNTARY ORGANIZATION</h4>

      </div>
      <div class="modal-body">
        <form enctype="multipart/form-data" method="post" role="form" action="">
          <div class="form-group" style="overflow-x:auto;">
            <table width="100%" class="table table-bordered">
              <tr>
                <th style="text-align:center;" rowspan="2">Name & Address of ORGANIZATION <br />(Write in full)</th>
                <th style="text-align:center;" colspan="2">INCLUSIVE DATES (yyyy-mm-dd)</th>
                <th style="text-align:center;" rowspan="2">Number of Hours</th>
                <th style="text-align:center;" rowspan="2">Position / Nature of Work</th>
              </tr>
              <tr>
                <th style="text-align:center;">From</th>
                <th style="text-align:center;">To</th>
              </tr>

              <tr>
                <th><input type="text" name="Organization" class="form-control" required></th>
                <th><input type="text" name="From" class="form-control" required></th>
                <th><input type="text" name="To" class="form-control" required></th>
                <th><input type="text" name="Hours" class="form-control" required></th>
                <th><input type="text" name="Position" class="form-control" required></th>
              </tr>

            </table>
          </div>
          <button type="submit" class="btn btn-primary" name="volwork" value="SAVE">ADD</button>
        </form>

      </div>
    </div>
  </div>
</div>

<!-- Modal for update Volunter-->
<div class="modal fade" id="myvolunter" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="loginbox">

    <!-- Modal content-->
    <div class="modal-content">




    </div>
  </div>
</div>
<!--Update Other-->