<?php
// modules/settings/index.php
require_once('app.php');

messageAlert($showAlert, $message, $success);
?>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php contentTitle('Settings'); ?>
  </div>

  <div class="card-body">
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link text-secondary active" href="#contact-details" data-toggle="tab">Contact Details</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-secondary" href="#password-change" data-toggle="tab">Password Change</a>
      </li>
    </ul>

    <div class="tab-content pt-2 px-2">
      <?php
      require_once('contacts.php');
      require_once('password.php');
      ?>
    </div>
  </div>
</div>