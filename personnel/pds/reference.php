<div class="tab-pane fade" id="references">
  <a href="#Myreference" class="btn btn-primary" data-toggle="modal" style="float:right">Add</a>
  <h4>
    42. References (Person not related by consanguinity or afinity to applicant / appointee) </h4>
  <div style="overflow-x:auto;width:100%;">
    <table width="100%" class="table table-striped table-bordered table-hover mb-0" id="dataTables-example">
      <thead>
        <tr>
          <th width="30%">Name</th>
          <th width="30%">Address</th>
          <th width="10%">Contact Number</th>
          <th width="7%"></th>
        </tr>

      </thead>
      <tbody>
        <?php
        $result8 = mysqli_query($con, "SELECT * FROM reference WHERE Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "'");
        while ($row8 = mysqli_fetch_array($result8)) {
          echo '<tr>
													<td style="text-align:center;">' . $row8['Name'] . '</td>
													<td style="text-align:center;">' . $row8['Address'] . '</td>
													<td style="text-align:center;">' . $row8['Tel_No'] . '</td>
													
														 <td style="text-align:center;">
																	<a href="my_references.php?id=' . urlencode(base64_encode($row8['No'])) . '" data-toggle="modal" data-target="#myfamily">Edit</a><br/>
																
																	<a style="cursor:pointer;" onclick="delete_reference(this.id)" id="' . $row8['No'] . '">Remove</a>
													
													  </td>
													</tr>';
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal for References-->
<div class="modal fade" id="my_references" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="loginbox">

    <!-- Modal content-->
    <div class="modal-content">

    </div>
  </div>
</div> <!-- End for References-->