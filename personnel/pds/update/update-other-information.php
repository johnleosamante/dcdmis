<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Update Other Information</h5>
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><!-- .modal-header -->

    <form method="post" role="form" action="">
      <?php
      include_once('../../../_includes_/function.php');
      include_once('../../../_includes_/database/database.php');

      foreach ($_GET as $key => $data) {
        $id = $_GET[$key] = $data;
      }

      $_SESSION['No'] = $id;

      $informations = mysqli_query($con, "SELECT * FROM other_information WHERE other_information.Emp_ID='" . $_SESSION['EmpID'] . "' AND other_information.No='$id' LIMIT 1;");

      if (mysqli_num_rows($informations) > 0) {
        $information = mysqli_fetch_array($informations);
        $skill = $information['Special_Skills'];
        $recognition = $information['Recognation'];
        $organization = $information['Organization'];
      } else {
        $skill = $recognition = $organization = '';
      }
      ?>
      <div class="modal-body">
        <div class="form-group">
          <label for="skills" class="mb-0">Special Skills &amp; Hobbies:</label>
          <input id="skills" type="text" name="myspecial" class="form-control" required value="<?php echo $skill; ?>">
        </div>

        <div class="form-group">
          <label for="awards" class="mb-0">Non-Academic Distinctions / Recognition (Write in full):</label>
          <input id="awards" type="text" name="myrecog" class="form-control" required value="<?php echo $recognition; ?>">
        </div>

        <div class="form-group mb-0">
          <label for="member" class="mb-0">Membership in Association / Organization (Write in full):</label>
          <input id="member" type="text" name="myorg" class="form-control" required value="<?php echo $organization; ?>">
        </div>
      </div><!-- .modal-body -->

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" name="UpdateOtherInformation">Save</button>
      </div>
    </form>
  </div><!-- .modal-content -->
</div><!-- modal-dialog -->