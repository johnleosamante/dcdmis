<div class="tab-pane fade<?php echo SetActiveNavigationTab(isset($_SESSION[GetSiteAlias() . '_pdstab']) && $_SESSION[GetSiteAlias() . '_pdstab'] === 'reference'); ?>" id="references">
  <div class="d-sm-flex align-items-center justify-content-between">
    <h3>References (Person not related by consanguinity or afinity to applicant / appointee)</h3>
    <a href="#AddReference" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"><span class="icon text-white-50"><i class="fas fa-plus fa-fw"></i></span><span class="text">Add</span></a>
  </div>

  <div class="row mt-3">
    <div class="col table-responsive">
      <table width="100%" class="table table-striped table-bordered table-hover mb-0" cellspacing="0">
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
</div>

<!-- Modal for References-->
<div class="modal fade" id="my_references" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="loginbox">

    <!-- Modal content-->
    <div class="modal-content">

    </div>
  </div>
</div> <!-- End for References-->