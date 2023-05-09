<?php
// modules/employees/employee-information.php
$employees = employee(real_escape_string($_GET['id']));

if (num_rows($employees) > 0) {
  $employee = fetch_assoc($employees);
  $_SESSION[alias() . '_No'] = $employee['id'];
} else {
  include_once(root() . '/modules/error/no-results-found.php');
  return;
}
?>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php content_title_with_link('Employee Information : ' . strtoupper(to_name($employee['lname'], $employee['fname'], $employee['mname'], $employee['ext'])), custom_uri('hrmis', 'Edit Employee'), 'Edit', 'fa-edit'); ?>
  </div>

  <div class="card-body pb-2">
    <ul class="nav nav-tabs mb-3">
      <li class="nav-item">
        <a class="nav-link text-secondary active" href="#personal-information" data-toggle="tab">Personal Information</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary" href="#family-background" data-toggle="tab">Family Background</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary" href="#children" data-toggle="tab">Children</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary" href="#educational-background" data-toggle="tab">Educational Background</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary" href="#civil-service-eligibility" data-toggle="tab">Civil Service Eligibility</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary" href="#work-experience" data-toggle="tab">Work Experience</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary" href="#voluntary-work" data-toggle="tab">Voluntary Work</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary" href="#learning-development" data-toggle="tab">Learning &amp; Development</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary" href="#special-skills" data-toggle="tab">Special Skills &amp; Hobbies</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary" href="#recognition" data-toggle="tab">Non-Academic Distinctions / Recognition</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary" href="#membership" data-toggle="tab">Membership in Association / Organization</a>
      </li><!-- .nav-item -->
    </ul><!-- .nav-tabs -->

    <div class="tab-content mt-2">
      <?php
      include_once(root() . '/modules/employees/view/personal-information.php');
      include_once(root() . '/modules/employees/view/family-background.php');
      include_once(root() . '/modules/employees/view/children.php');
      include_once(root() . '/modules/employees/view/educational-background.php');
      include_once(root() . '/modules/employees/view/civil-service-eligibility.php');
      include_once(root() . '/modules/employees/view/work-experience.php');
      include_once(root() . '/modules/employees/view/voluntary-work.php');
      include_once(root() . '/modules/employees/view/learning-development.php');
      include_once(root() . '/modules/employees/view/special-skills.php');
      include_once(root() . '/modules/employees/view/recognition.php');
      include_once(root() . '/modules/employees/view/membership.php');
      ?>
    </div><!-- .tab-content -->
  </div><!-- .card-body -->
</div><!-- .card -->