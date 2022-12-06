<div class="tab-pane fade" id="family-background">
  <a href="#myfb" data-toggle="modal" style="float:right" class="btn btn-primary">Add</a>
  <h4>II. Family Background</h4>
  <div style="overflow-x:auto;width:100%;">
    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
      <thead>
        <tr>
          <th width="20%">Family Name</th>
          <th width="20%">First Name</th>
          <th width="20%">Middle Name</th>
          <th width="10%">Birthdate</th>
          <th width="10%">Relation</th>
          <th width="10%"></th>

        </tr>

      </thead>
      <tbody>
        <?php
        $result1 = mysqli_query($con, "SELECT * FROM family_background WHERE Emp_ID='" . $_SESSION['EmpID'] . "'");
        while ($row1 = mysqli_fetch_array($result1)) {
          echo '<tr><td style="text-align:center;">' . $row1['Family_Name'] . '</td>
													  <td style="text-align:center;">' . $row1['First_Name'] . '</td>
													  <td style="text-align:center;">' . $row1['Middle_Name'] . '</td>
													  <td style="text-align:center;">' . $row1['Birthdate'] . '</td>
													  <td style="text-align:center;">' . $row1['Relation'] . '</td>
														<td style="text-align:center;">
															
																	<a href="my_family.php?id=' . urlencode(base64_encode($row1['No'])) . '" data-toggle="modal" data-target="#myfamily">Edit</a><br/>
																
																	<a style="cursor:pointer;" id="' . $row1['No'] . '" onclick="delete_option(this.id)">Remove</a>
															
													  </td>
												  </tr>';
        }

        ?>
      </tbody>
    </table>
  </div>
</div>


<script>
  function delete_option(id) {
    if (confirm("Are you sure you want to deleted this row?")) {

      window.location.href = 'delete_fam.php?id=' + id;
    }
  }
</script>

<!-- Modal for Family BACKGROUND-->
<div class="modal fade" id="myfb" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="loginbox">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">II. FAMILY BACKGROUND </h4>
      </div>
      <div class="modal-body">
        <div style="overflow-x:auto;">
          <form enctype="multipart/form-data" method="post" role="form" action="">
            <div class="form-group">
              <table width="100%" class="table table-bordered">
                <tr>
                  <th>Family Name</th>
                  <th>First Name</th>
                  <th>Middle Name</th>
                  <th>Birthdate</th>
                  <th>Relation</th>
                </tr>
                <tr>
                  <td><input type="text" name="Lname" class="form-control" required></td>
                  <td><input type="text" name="Fname" class="form-control" required></td>
                  <td><input type="text" name="Mname" class="form-control" required></td>
                  <td><input type="date" name="Birthdate" class="form-control" required></td>
                  <td><input type="text" name="Relation" class="form-control" required></td>
                </tr>

              </table>
            </div>
        </div>
        <input type="submit" class="btn btn-primary" name="save_fam" value="SAVE">
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal for update Volunter-->
<div class="modal fade" id="myfamily" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="loginbox">

    <!-- Modal content-->
    <div class="modal-content">




    </div>
  </div>
</div>
<!--Update Other-->