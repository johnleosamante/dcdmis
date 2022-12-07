<div class="tab-pane fade<?php echo SetActiveNavigationTab(isset($_SESSION['pdstab']) &&$_SESSION['pdstab'] === 'family-background'); ?>" id="family-background">
  <div class="d-sm-flex align-items=center justify-content-between">
    <h3 class="h4 mb-0">Family Background</h3>
    <a href="#AddFamilyMemberModal" data-toggle="modal" class="btn btn-primary btn-icon-split btn-sm"><span class="icon text-white-50"><i class="fas fa-plus fa-fw"></i></span><span class="text">Add</span></a>
  </div><!-- .d-sm-flex -->

  <div class="row mt-3">
    <div class="col table-responsive">
      <table width="100%" class="table table-striped table-bordered table-hover mb-2" cellspacing="0">
        <thead>
          <tr>
            <th class="text-center" width="20%">Last Name</th>
            <th class="text-center" width="20%">First Name</th>
            <th class="text-center" width="20%">Middle Name</th>
            <th class="text-center" width="15%">Date of Birth</th>
            <th class="text-center" width="15%">Relationship</th>
            <th class="text-center" width="10%">Actions</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $result1 = mysqli_query($con, "SELECT * FROM family_background WHERE Emp_ID='" . $_SESSION['EmpID'] . "'");

          if (mysqli_num_rows($result1) > 0) {
            while ($row1 = mysqli_fetch_array($result1)) { ?>
              <tr>
                <td class="text-center align-middle"><?php echo $row1['Family_Name']; ?></td>
                <td class="text-center align-middle"><?php echo $row1['First_Name']; ?></td>
                <td class="text-center align-middle"><?php echo $row1['Middle_Name']; ?></td>
                <td class="text-center align-middle"><?php echo $row1['Birthdate']; ?></td>
                <td class="text-center align-middle"><?php echo $row1['Relation']; ?></td>
                <td class="text-center align-middle">
                  <a class="btn btn-success my-1" href="my_family.php?id=<?php echo GetDecoding($row1['No']); ?>" data-toggle="modal" data-target="#UpdateFamilyMemberModal" title="Edit"><i class="fas fa-edit fa-fw"></i></a>
                  <a class="btn btn-danger my-1" id="<?php echo $row1['No']; ?>" onclick="delete_option(this.id)" title="Remove"><i class="fas fa-trash fa-fw"></i></a>
                </td>
              </tr>
            <?php
            }
          } else { ?>
            <tr>
              <td class="text-center align-middle">-</td>
              <td class="text-center align-middle">-</td>
              <td class="text-center align-middle">-</td>
              <td class="text-center align-middle">-</td>
              <td class="text-center align-middle">-</td>
              <td class="text-center align-middle">-</td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>

      <script>
        function delete_option(id) {
          if (confirm("Are you sure you want to deleted this row?")) {
            window.location.href = 'delete_fam.php?id=' + id;
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

        <form enctype="multipart/form-data" method="post" role="form" action="">
          <div class="modal-body">
            <div class="form-group">
              <label for="LastName">Last Name:</label>
              <input id="LastName" type="text" name="Lname" class="form-control" placeholder="Last Name" required>
            </div>

            <div class="form-group">
              <label for="FirstName">First Name:</label>
              <input id="FirstName" type="text" name="Fname" class="form-control" placeholder="First Name" required>
            </div>

            <div class="form-group">
              <label for="MiddleName">Middle Name:</label>
              <input id="MiddleName" type="text" name="Mname" class="form-control" placeholder="Middle Name">
            </div>

            <div class="form-group">
              <label for="DateOfBirth">Date of Birth:</label>
              <input id="DateOfBirth" type="date" name="Birthdate" class="form-control" required>
            </div>

            <div class="form-group mb-0">
              <label for="Relationship">Relationship:</label>
              <input id="Relationship" type="text" name="Relation" class="form-control" placeholder="Relationship" required>
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

  <div class="modal fade" id="UpdateFamilyMemberModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">

      </div>
    </div>
  </div>
</div>