<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Update Family Member</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
    </div><!-- .modal-header -->

    <form method="post" role="form" action="">
      <?php
      include_once('../../../_includes_/function.php');
      include_once('../../../_includes_/database/database.php');

      foreach ($_GET as $key => $data) {
        $id = $_GET[$key] = $data;
      }

      $_SESSION['No'] = $id;

      $family = mysqli_query($con, "SELECT * FROM family_background WHERE family_background.No='$id' LIMIT 1;");

      if (mysqli_num_rows($family) > 0) {
        $member = mysqli_fetch_array($family);
        $fname = $member['First_Name'];
        $mname = $member['Middle_Name'];
        $lname = $member['Family_Name'];
        $bdate = $member['Birthdate'];
        $relation = $member['Relation'];
      } else {
        $fname = $mname = $lname = $bdate = $relation = '';
      }
      ?>
      <div class="modal-body">
        <div class="form-group">
          <label for="LastName" class="mb-0">Last Name:</label>
          <input id="LastName" type="text" name="Lname" class="form-control" value="<?php echo $lname; ?>" required>
        </div>

        <div class="form-group">
          <label for="FirstName" class="mb-0">First Name:</label>
          <input id="FirstName" type="text" name="Fname" class="form-control" value="<?php echo $fname; ?>" required>
        </div>

        <div class="form-group">
          <label for="MiddleName" class="mb-0">Middle Name:</label>
          <input id="MiddleName" type="text" name="Mname" class="form-control" value="<?php echo $mname; ?>">
        </div>

        <div class="form-group">
          <label for="DateOfBirth" class="mb-0">Date of Birth:</label>
          <input id="DateOfBirth" type="date" name="Bdate" class="form-control" value="<?php echo $bdate; ?>" required>
        </div>

        <div class="form-group mb-0">
          <label for="Relationship" class="mb-0">Relationship:</label>
          <input id="Relationship" type="text" name="Relate" class="form-control" value="<?php echo $relation; ?>" required>
        </div>
      </div><!-- .modal-body -->

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <input type="submit" class="btn btn-primary" name="UpdateFamilyMember" value="Save">
      </div><!-- .modal-footer -->
    </form>
  </div><!-- .modal-content -->
</div><!-- .modal-dialog -->