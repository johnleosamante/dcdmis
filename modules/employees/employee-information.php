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
    <?php content_title_with_link('Employee Information', uri() . '/hrmis'); ?>
  </div>

  <div class="card-body">
    <ul class="nav nav-tabs mb-3">
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo set_active_navigation(!isset($_SESSION[alias() . '_employee_tab']) || $_SESSION[alias() . '_employee_tab'] === 'personal-information', 'show active'); ?>" href="#personal-information" data-toggle="tab">Personal Information</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo set_active_navigation(isset($_SESSION[alias() . '_employee_tab']) && $_SESSION[alias() . '_employee_tab'] ===  'family-background', 'show active'); ?>" href="#family-background" data-toggle="tab">Family Background</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo set_active_navigation(isset($_SESSION[alias() . '_employee_tab']) && $_SESSION[alias() . '_employee_tab'] === 'children', 'show active'); ?>" href="#children" data-toggle="tab">Children</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo set_active_navigation(isset($_SESSION[alias() . '_employee_tab']) && $_SESSION[alias() . '_employee_tab'] === 'educational-background', 'show active'); ?>" href="#educational-background" data-toggle="tab">Educational Background</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo set_active_navigation(isset($_SESSION[alias() . '_employee_tab']) && $_SESSION[alias() . '_employee_tab'] === 'eligibility', 'show active'); ?>" href="#eligibility" data-toggle="tab">Civil Service Eligibility</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo set_active_navigation(isset($_SESSION[alias() . '_employee_tab']) && $_SESSION[alias() . '_employee_tab'] === 'work-experience', 'show active'); ?>" href="#work-experience" data-toggle="tab">Work Experience</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo set_active_navigation(isset($_SESSION[alias() . '_employee_tab']) && $_SESSION[alias() . '_employee_tab'] === 'voluntary-work', 'show active'); ?>" href="#voluntary-work" data-toggle="tab">Voluntary Work</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo set_active_navigation(isset($_SESSION[alias() . '_employee_tab']) && $_SESSION[alias() . '_employee_tab'] === 'learning-development', 'show active'); ?>" href="#learning-development" data-toggle="tab">Learning and Development</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo set_active_navigation(isset($_SESSION[alias() . '_employee_tab']) && $_SESSION[alias() . '_employee_tab'] === 'special-skills', 'show active'); ?>" href="#special-skills" data-toggle="tab">Special Skills &amp; Hobbies</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo set_active_navigation(isset($_SESSION[alias() . '_employee_tab']) && $_SESSION[alias() . '_employee_tab'] === 'recognition', 'show active'); ?>" href="#recognition" data-toggle="tab">Non-Academic Distinctions / Recognition</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo set_active_navigation(isset($_SESSION[alias() . '_employee_tab']) && $_SESSION[alias() . '_employee_tab'] === 'membership', 'show active'); ?>" href="#membership" data-toggle="tab">Membership in Association / Organization</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo set_active_navigation(isset($_SESSION[alias() . '_employee_tab']) && $_SESSION[alias() . '_employee_tab'] === 'other-information', 'show active'); ?>" href="#other-information" data-toggle="tab">Other Information</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo set_active_navigation(isset($_SESSION[alias() . '_employee_tab']) && $_SESSION[alias() . '_employee_tab'] === 'reference', 'show active'); ?>" href="#reference" data-toggle="tab">References</a>
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
      include_once(root() . '/modules/employees/view/other-information.php');
      include_once(root() . '/modules/employees/view/reference.php');
      ?>
    </div><!-- .tab-content -->
  </div><!-- .card-body -->
</div><!-- .card -->