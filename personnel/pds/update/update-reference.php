<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">References</h5>
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>

    <form method="post" role="form" action="">
      <?php
      include_once('../../../_includes_/function.php');
      include_once('../../../_includes_/database/database.php');

      foreach ($_GET as $key => $data) {
        $id = $_GET[$key] = $data;
      }

      $_SESSION['No'] = $id;

      $references = mysqli_query($con, "SELECT * FROM reference WHERE Emp_ID='" . $_SESSION['EmpID'] . "' AND No='$id' LIMIT 1;");

      if (mysqli_num_rows($references) > 0) {
        $reference = mysqli_fetch_array($references);
        $name = $reference['Name'];
        $address = $reference['Address'];
        $contact = $reference['Tel_No'];
      } else {
        $name = $address = $contact = '';
      }
      ?>
      <div class="modal-body">
        <div class="form-group">
          <label for="Ref_Name" class="mb-0">Name:</label>
          <input type="text" id="Ref_Name" name="RefName" class="form-control" required value="<?php echo $name; ?>">
        </div>

        <div class="form-group">
          <label for="Address" class="mb-0">Address:</label>
          <input type="text" id="Address" name="RefAddress" class="form-control" required value="<?php echo $address; ?>">
        </div>

        <div class="form-group">
          <label for="Cell" class="mb-0">Contact Number:</label>
          <input type="text" id="Cell" name="RefContact" class="form-control" required value="<?php echo $contact; ?>">
        </div>
      </div><!-- .modal-body -->

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" name="UpdateReference">Save</button>
      </div><!-- .modal-footer -->
    </form>
  </div><!-- .modal-content -->
</div><!-- .modal-dialog -->