<?php
// modules/settings/index.php
include_once('app.php');
?>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php contentTitle($pageTitle); ?>
  </div>

  <div class="card-body">
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link text-secondary active" href="#change-password" data-toggle="tab">Change Password</a>
      </li>
    </ul>

    <div class="tab-content pt-2 px-2">
      <?php include_once('change-password.php'); ?>
    </div>
  </div>
</div>