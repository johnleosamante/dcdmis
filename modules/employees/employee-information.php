<?php
// modules/employees/employee-information.php
$employees = employee(sanitize($_GET['id']));

if (numRows($employees) > 0) {
  $employee = fetchAssoc($employees);
} else {
  include_once(root() . '/modules/error/no-results-found.php');
  return;
}

if (!is_dir('../uploads/images/' . $employee['id'])) {
  mkdir('../uploads/images/' . $employee['id'], 0777, true);
}

$_SESSION[alias() . '_current_employee_id'] = $_SESSION[alias() . '_current_employee_photo'] = '';

$editMode = $url === 'Edit Employee Information';
?>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php if (!$editMode) {
      $_SESSION[alias() . '_pds_tab'] = 'personal-information';
      contentTitleWithLink('Employee Information : ' . strtoupper(toName($employee['lname'], $employee['fname'], $employee['mname'], $employee['ext'])), customUri('hrmis', 'Edit Employee Information', $employee['id']), 'Edit', 'fa-edit');
    } else {
      $_SESSION[alias() . '_current_employee_id'] = $employee['id'];
      $_SESSION[alias() . '_current_employee_photo'] = $employee['picture'];
      contentTitleWithLink('Update Employee Information : ' . strtoupper(toName($employee['lname'], $employee['fname'], $employee['mname'], $employee['ext'])), customUri('hrmis', 'Employee Information', $employee['id']));
    }

    $pds_progress = 0;

    if (numRows(employee($employee['id'])) > 0) {
      $pds_progress += 15;
    }

    if (numRows(family($employee['id'])) > 0) {
      $pds_progress += 10;
    }

    if (numRows(educationalBackgrounds($employee['id'])) > 0) {
      $pds_progress += 15;
    }

    if (numRows(eligibilities($employee['id'])) > 0) {
      $pds_progress += 15;
    }

    if (numRows(experiences($employee['id'])) > 0) {
      $pds_progress += 15;
    }

    if (numRows(learningAndDevelopment($employee['id'])) > 0) {
      $pds_progress += 15;
    }

    if (numRows(specialSkills($employee['id'])) > 0) {
      $pds_progress += 5;
    }

    if (numRows(otherInformation($employee['id'])) > 0) {
      $pds_progress += 10;
    }
    ?>

    <div class="progress mt-1" title="<?php echo $pds_progress; ?>% Complete">
      <div class="progress-bar bg-success" role="progressbar" aria-valuenow="<?php echo $pds_progress; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $pds_progress; ?>%"></div>
    </div><!-- .progress -->
  </div>

  <div class="card-body pb-2">
    <ul class="nav nav-tabs mb-3">
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo setActiveNavigation(!isset($_SESSION[alias() . '_pds_tab']) || $_SESSION[alias() . '_pds_tab'] === 'personal-information'); ?>" href="#personal-information" data-toggle="tab">Personal Information</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo setActiveNavigation(isset($_SESSION[alias() . '_pds_tab']) && $_SESSION[alias() . '_pds_tab'] === 'family-background'); ?>" href="#family-background" data-toggle="tab">Family Background</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo setActiveNavigation(isset($_SESSION[alias() . '_pds_tab']) && $_SESSION[alias() . '_pds_tab'] === 'children'); ?>" href="#children" data-toggle="tab">Children</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo setActiveNavigation(isset($_SESSION[alias() . '_pds_tab']) && $_SESSION[alias() . '_pds_tab'] === 'educational-background'); ?>" href="#educational-background" data-toggle="tab">Educational Background</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo setActiveNavigation(isset($_SESSION[alias() . '_pds_tab']) && $_SESSION[alias() . '_pds_tab'] === 'civil-service-eligibility'); ?>" href="#civil-service-eligibility" data-toggle="tab">Civil Service Eligibility</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo setActiveNavigation(isset($_SESSION[alias() . '_pds_tab']) && $_SESSION[alias() . '_pds_tab'] === 'work-experience'); ?>" href="#work-experience" data-toggle="tab">Work Experience</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo setActiveNavigation(isset($_SESSION[alias() . '_pds_tab']) && $_SESSION[alias() . '_pds_tab'] === 'voluntary-work'); ?>" href="#voluntary-work" data-toggle="tab">Voluntary Work</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo setActiveNavigation(isset($_SESSION[alias() . '_pds_tab']) && $_SESSION[alias() . '_pds_tab'] === 'learning-development'); ?>" href="#learning-development" data-toggle="tab">Learning &amp; Development</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo setActiveNavigation(isset($_SESSION[alias() . '_pds_tab']) && $_SESSION[alias() . '_pds_tab'] === 'special-skills'); ?>" href="#special-skills" data-toggle="tab">Special Skills &amp; Hobbies</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo setActiveNavigation(isset($_SESSION[alias() . '_pds_tab']) && $_SESSION[alias() . '_pds_tab'] === 'recognition'); ?>" href="#recognition" data-toggle="tab">Non-Academic Distinctions / Recognition</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo setActiveNavigation(isset($_SESSION[alias() . '_pds_tab']) && $_SESSION[alias() . '_pds_tab'] === 'membership'); ?>" href="#membership" data-toggle="tab">Membership in Association / Organization</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo setActiveNavigation(isset($_SESSION[alias() . '_pds_tab']) && $_SESSION[alias() . '_pds_tab'] === 'other-information'); ?>" href="#other-information" data-toggle="tab">Other Information</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo setActiveNavigation(isset($_SESSION[alias() . '_pds_tab']) && $_SESSION[alias() . '_pds_tab'] === 'reference'); ?>" href="#reference" data-toggle="tab">References</a>
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