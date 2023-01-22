<?php
include_once('../../../_includes_/function.php');
include_once('../../../_includes_/database/database.php');

foreach ($_GET as $key => $data) {
  $id = $_GET[$key] = $data;
}

$_SESSION['No'] = $id;
?>

<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Remove Child?</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
    </div>

    <div class="modal-body">
      Are you sure you want to continue and remove this child?
    </div>

    <div class="modal-footer">
      <form action="" method="POST" role="form">
        <input type="submit" class="btn btn-danger" name="RemoveChild" value="Yes, Continue">
        <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </form>
    </div>
  </div>
</div>