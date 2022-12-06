<div class="tab-pane fade" id="learning-development">
  <a href="#Mylearning" class="btn btn-primary" data-toggle="modal" style="float:right">Add</a>
  <h4>VII. Learning and Development (L&D)Interventions/ Training programs attended</h4>
  <div style="overflow-x:auto;width:100%;">
    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
      <thead>
        <tr>
          <th width="30%" rowspan="2">Title Learning and Development Interventions / Training programs <br />(write in full)</th>
          <th width="10%" colspan="2">Inclusive Dates <br />(mm/dd/yyyy)</th>
          <th width="10%" rowspan="2">Number of hours</th>
          <th width="25%" rowspan="2">Type of LD (Managerial / Supervisor / Technical / etc)</th>
          <th width="25%" rowspan="2">Conducted / Sponsored by<br />(Write in Full) </th>
          <th rowspan="2" width="7%"></th>
        </tr>
        <tr>
          <th>From</th>
          <th>To</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $result6 = mysqli_query($con, "SELECT * FROM learning_and_development WHERE Emp_ID='" . $_SESSION['EmpID'] . "' ORDER BY No Asc");
        while ($row6 = mysqli_fetch_array($result6)) {
          echo  '<tr>
															<td style="text-align:center;">' . $row6['Title_of_Training'] . '</td>
															<td style="text-align:center;">' . $row6['From'] . '</td>
															<td style="text-align:center;">' . $row6['To'] . '</td>
															<td style="text-align:center;">' . $row6['Number_of_Hours'] . '</td>
															<td style="text-align:center;">' . $row6['Managerial'] . '</td>
															<td style="text-align:center;">' . $row6['Conducted'] . '</td>

														 <td style="text-align:center;">
															
																	<a href="my_training.php?id=' . urlencode(base64_encode($row6['No'])) . '" data-toggle="modal" data-target="#myfamily"> Edit</a><br/>
																	<a style="cursor:pointer;" onclick="delete_LD(this.id)" id="' . $row6['No'] . '">Remove</a>
													
													  </td>

														
														</tr>';
        }

        ?>
      </tbody>
    </table>
  </div>
</div>

<script>
  function delete_LD(id) {
    if (confirm("Are you sure you want to deleted this row?")) {

      window.location.href = 'delete_LD.php?id=' + id;
    }
  }
</script>

<!-- Modal for Leraning Work-->
<div class="modal fade" id="Mylearning" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="loginbox">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">VII. learning and development (L&D)interventions/ training programs attended
          (Start from the most recent L & D training program and include only the relevant L&D/training taken for the five(5)years for the Division Chief/Executive Managerial positions)
      </div>
      <div class="modal-body">
        <form enctype="multipart/form-data" method="post" role="form" action="">
          <div class="form-group" style="overflow-x:auto;">
            <table width="100%" class="table table-bordered">
              <tr>
                <th style="text-align:center;" rowspan="2">Title Learning and development interventions / training programs <br /> (write in full)</th>
                <th style="text-align:center;" colspan="2">Inclusive date <br />(mm/dd/yyyy)</th>
                <th style="text-align:center;" rowspan="2">Number of hours</th>
                <th style="text-align:center;" rowspan="2">Type of LD (Managerial / Supervisor / Technical / etc)</th>
                <th style="text-align:center;" rowspan="2">Conducted / Sponsored by <br />(Write in Full) </th>

              </tr>
              <tr>
                <th style="text-align:center;">From</th>
                <th style="text-align:center;">To</th>
              </tr>

              <tr>
                <th><input type="text" name="Title_learning" class="form-control" required></th>
                <th><input type="date" name="From" class="form-control" required></th>
                <th><input type="date" name="To" class="form-control" required></th>
                <th><input type="text" name="No_of_hours" class="form-control" required></th>
                <th><input type="text" name="Position" class="form-control" required></th>
                <th><input type="text" name="Conducted" class="form-control" required></th>
              </tr>

            </table>
          </div>
          <button type="submit" class="btn btn-primary" name="learning_dev" value="SAVE">ADD</button>
        </form>

      </div>
    </div>
  </div>
</div>

<!-- Modal for update Cell_No-->
<div class="modal fade" id="mytraining" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="loginbox">

    <!-- Modal content-->
    <div class="modal-content">




    </div>
  </div>
</div>
<!--Update Other-->