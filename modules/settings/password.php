<?php
// modules/settings/change-password.php
?>
<div class="tab-pane fade show active" id="change-password">
  <form class="py-2" action="" method="post">
    <div class="row">
      <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
        <div class="form-group">
          <label for="old-password" class="mb-0">Old Password:</label>
          <div class="input-group">
            <input id="old-password" name="old-password" type="password" class="form-control border-right-0" required>
            <div class="input-group-append">
              <button type="button" id="eye-toggle-old" class="input-group-text border-left-0 bg-white">
                <i id="eye" class="small fas fa-eye fa-sm"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
        <div class="form-group">
          <label for="password" class="mb-0">New Password:</label>
          <div class="input-group">
            <input id="password" name="password" type="password" class="form-control border-right-0" required>
            <div class="input-group-append">
              <button type="button" id="eye-toggle" class="input-group-text border-left-0 bg-white">
                <i id="eye" class="small fas fa-eye fa-sm"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
        <div class="form-group">
          <label for="confirm-new-password" class="mb-0">Retype New Password:</label>
          <div class="input-group">
            <input id="confirm-new-password" name="confirm-new-password" type="password" class="form-control border-right-0" required>
            <div class="input-group-append">
              <button type="button" id="eye-toggle" class="input-group-text border-left-0 bg-white">
                <i id="eye" class="small fas fa-eye fa-sm"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
        <input name="update-password" type="submit" value="Update Password" class="btn btn-primary btn-block btn-lg">
      </div>
    </div>
  </form>
</div>