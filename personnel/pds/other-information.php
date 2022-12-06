<div class="tab-pane fade" id="other-information">
  <a href="#MyOther" class="btn btn-primary" data-toggle="modal" style="float:right">Add</a>
  <h4>VIII. OTHER INFORMATION</h4>
  <div style="overflow-x:auto;width:100%;">
    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
      <thead>
        <tr>
          <th width="30%">SPECIAL SKILLS and HOBBIES</th>
          <th width="30%">NON-ACADEMIC DISTINCTIONS / RECOGNITION <br /> (Write in full)</th>
          <th width="30%">MEMBERSHIP IN ASSOCIATION/ORGANIZATION <br />(Write in full)</th>
          <th width="7%"></th>

        </tr>

      </thead>
      <tbody>
        <?php
        $result7 = mysqli_query($con, "SELECT * FROM other_information WHERE other_information.Emp_ID='" . $_SESSION['EmpID'] . "'");
        while ($row7 = mysqli_fetch_array($result7)) {
          echo  '<tr>
															<td style="text-align:center;">' . $row7['Special_Skills'] . '</td>
															<td style="text-align:center;">' . $row7['Recognation'] . '</td>
															<td style="text-align:center;">' . $row7['Organization'] . '</td>
															
															 <td style="text-align:center;">
																	<a href="update_skills.php?id=' . urlencode(base64_encode($row7['No'])) . '" data-toggle="modal" data-target="#myfamily"> Edit</a><br/>
																<a style="cursor:pointer;" onclick="delete_other(this.id)" id="' . $row7['No'] . '">Remove</a>
													
													  </td>
														</tr>';
        }

        ?>
      </tbody>
    </table>
  </div>
</div>

<script>
  function delete_other(id) {
    if (confirm("Are you sure you want to deleted this row?")) {

      window.location.href = 'delete_other.php?id=' + id;
    }
  }
</script>

<!-- Modal for Family BACKGROUND-->
<div class="modal fade" id="MyOther" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="loginbox">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">VIII. OTHER INFORMATION </h4>
      </div>
      <div class="modal-body">
        <form enctype="multipart/form-data" method="post" role="form" action="">
          <div class="form-group" style="overflow-x:auto;">
            <table width="100%" class="table table-bordered">
              <tr>
                <th>SPECIAL SKILLS and HOBBIES</th>
                <th>NON-ACADEMIC DISTINCTIONS / RECOGNITION (Write in full)</th>
                <th>MEMBERSHIP IN ASSOCIATION/ORGANIZATION (Write in full)</th>
              </tr>
              <tr>
                <td><input type="text" name="skills" class="form-control" required></td>
                <td><input type="text" name="awards" class="form-control" required></td>
                <td><input type="text" name="member" class="form-control" required></td>

              </tr>

            </table>
          </div>
          <button type="submit" class="btn btn-primary" name="save_other" value="SAVE">SUBMIT</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal for update Cell_No-->
<div class="modal fade" id="myskills" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="loginbox">

    <!-- Modal content-->
    <div class="modal-content">




    </div>
  </div>
</div>
<!--Update Other-->