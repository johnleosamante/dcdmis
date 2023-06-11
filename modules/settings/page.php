<?php
// modules/settings/index.php
require_once('app.php');

messageAlert($showPrompt, $message, $success);
?>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php contentTitle($pageTitle); ?>
  </div>

  <div class="card-body">
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link text-secondary active" href="#password" data-toggle="tab">Password</a>
      </li>
    </ul>

    <div class="tab-content pt-2 px-2">
      <?php require_once('password.php'); ?>
    </div>
  </div>
</div>