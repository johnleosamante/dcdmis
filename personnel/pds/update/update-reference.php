<?php
include_once('../../../_includes_/function.php');
include_once('../../../_includes_/database/database.php');

foreach ($_GET as $key => $data) {
  $id = $_GET[$key] = $data;
}

$_SESSION['No'] = $name = $address = $contact = '';
$modalTitle = "Add Reference";

if (strlen($id) > 0) {
  $_SESSION['No'] = $id;
  $modalTitle = "Edit Reference";
  $references = mysqli_query($con, "SELECT * FROM reference WHERE Emp_ID='" . $_SESSION['EmpID'] . "' AND No='$id' LIMIT 1;");

  if (mysqli_num_rows($references) > 0) {
    $reference = mysqli_fetch_array($references);
    $name = $reference['Name'];
    $address = $reference['Address'];
    $contact = $reference['Tel_No'];
  }
}
?>

<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title"><?php echo $modalTitle; ?></h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
    </div>

    <form method="post" role="form" action="">
      <div class="modal-body">
        <div class="form-group">
          <label for="Ref_Name" class="mb-0">Name: <span class="text-danger">*</span></label>
          <input type="text" id="Ref_Name" name="RefName" class="form-control" required value="<?php echo $name; ?>">
        </div>

        <div class="form-group">
          <label for="Address" class="mb-0">Address: <span class="text-danger">*</span></label>
          <input type="text" id="Address" name="RefAddress" class="form-control" required value="<?php echo $address; ?>">
        </div>

        <div class="form-group">
          <label for="Cell" class="mb-0">Contact Number: <span class="text-danger">*</span></label>
          <input type="text" id="Cell" name="RefContact" class="form-control" required value="<?php echo $contact; ?>">
        </div>

        <div class="text-danger mb-0">* Required field</div>
      </div><!-- .modal-body -->

      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="SaveReference">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div><!-- .modal-footer -->
    </form>
  </div><!-- .modal-content -->
</div><!-- .modal-dialog -->