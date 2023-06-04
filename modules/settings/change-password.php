<?php
// modules/settings/change-password.php
?>
<div class="tab-pane fade show active" id="change-password">
  <form class="py-2" action="" method="post">
    <div class="row">
      <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
        <div class="form-group">
          <label for="old-password" class="mb-0">Old Password:</label>
          <input id="old-password" name="old-password" type="password" class="form-control" required>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
        <div class="form-group">
          <label for="new-password" class="mb-0">New Password:</label>
          <input id="new-password" name="new-password" type="password" class="form-control" required>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
        <div class="form-group">
          <label for="confirm-new-password" class="mb-0">Retype New Password:</label>
          <input id="confirm-new-password" name="confirm-new-password" type="password" class="form-control" required>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
        <input name="change-password" type="submit" value="Change Password" class="btn btn-primary btn-block btn-lg">
      </div>
    </div>
  </form>
</div>