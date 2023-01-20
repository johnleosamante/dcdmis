<div class="tab-pane fade<?php echo SetActiveNavigationTab(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'family-background'); ?>" id="family-background">
  <div class="d-sm-flex align-items=center justify-content-between">
    <h3 class="h4 mb-0">Family Background</h3>
    <a href="#AddFamilyMemberModal" data-toggle="modal" class="btn btn-primary btn-icon-split btn-sm"><span class="icon text-white-50"><i class="fas fa-plus fa-fw"></i></span><span class="text">Add</span></a>
  </div><!-- .d-sm-flex -->

  <div class="row mt-3">
    <div class="col table-responsive">
      <table width="100%" class="table table-striped table-bordered table-hover mb-0" cellspacing="0">
        <thead>
          <tr class="text-center">
            <th width="20%">Last Name</th>
            <th width="20%">First Name</th>
            <th width="20%">Middle Name</th>
            <th width="15%">Date of Birth</th>
            <th width="15%">Relationship</th>
            <th width="10%">Action</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $familyMembers = mysqli_query($con, "SELECT * FROM family_background WHERE Emp_ID='" . $_SESSION['EmpID'] . "' ORDER BY Birthdate DESC;");

          if (mysqli_num_rows($familyMembers) > 0) {
            while ($member = mysqli_fetch_array($familyMembers)) { ?>
              <tr>
                <td class="text-center align-middle"><?php echo $member['Family_Name']; ?></td>
                <td class="text-center align-middle"><?php echo $member['First_Name']; ?></td>
                <td class="text-center align-middle"><?php echo $member['Middle_Name']; ?></td>
                <td class="text-center align-middle"><?php echo ToLongDateString($member['Birthdate']); ?></td>
                <td class="text-center align-middle"><?php echo $member['Relation']; ?></td>
                <td class="text-center align-middle">
                  <a class="btn btn-success my-1" onclick="viewdata('UpdateModal', 'pds/update/update-family-member.php?id=<?php echo $member['No']; ?>')" data-toggle="modal" data-target="#UpdateModal" title="Edit"><i class="fas fa-edit fa-fw"></i></a>
                  <a class="btn btn-danger my-1" onclick="delete_option(<?php echo $member['No']; ?>)" title="Remove"><i class="fas fa-trash fa-fw"></i></a>
                </td>
              </tr>
            <?php
            }
          } else { ?>
            <tr>
              <td class="text-center align-middle" colspan="6">No data available in table.</td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>

      <script>
        function delete_option(id) {
          if (confirm("Are you sure you want to delete this entry?")) {
            window.location.href = 'pds/delete/delete-family-member.php?id=' + id;
          }
        }
      </script>
    </div>
  </div>

  <div class="modal fade" id="AddFamilyMemberModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Family Member</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        </div><!-- .modal-header -->

        <form method="post" role="form" action="">
          <div class="modal-body">
            <div class="form-group">
              <label for="LastName" class="mb-0">Last Name:</label>
              <input id="LastName" type="text" name="Lname" class="form-control" required>
            </div>

            <div class="form-group">
              <label for="FirstName" class="mb-0">First Name:</label>
              <input id="FirstName" type="text" name="Fname" class="form-control" required>
            </div>

            <div class="form-group">
              <label for="MiddleName" class="mb-0">Middle Name:</label>
              <input id="MiddleName" type="text" name="Mname" class="form-control">
            </div>

            <div class="form-group">
              <label for="DateOfBirth" class="mb-0">Date of Birth:</label>
              <input id="DateOfBirth" type="date" name="Birthdate" class="form-control" required>
            </div>

            <div class="form-group mb-0">
              <label for="Relationship" class="mb-0">Relationship:</label>
              <input id="Relationship" type="text" name="Relation" class="form-control" required>
            </div>
          </div><!-- .modal-body -->

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <input type="submit" class="btn btn-primary" name="AddFamilyMember" value="Save">
          </div><!-- .modal-footer -->
        </form>
      </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
  </div><!-- .modal -->
</div>