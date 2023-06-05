<?php
// modules/employees/employee-information.php
$employeeId = isset($_GET['id']) ? sanitize($_GET['id']) : null;
$employees = employee($employeeId);

if (numRows($employees) > 0) {
  $employee = fetchAssoc($employees);
  $employeeId = $employee['id'];
} else {
  include_once(root() . '/modules/error/no-results-found.php');
  return;
}

if (!is_dir('../uploads/images/' . $employeeId)) {
  mkdir('../uploads/images/' . $employeeId, 0777, true);
}

$editMode = $url === 'Edit Employee Information';
$employeePhoto = '';

messageAlert($showPrompt, $message, $success);
?>

<div class="card border-left-primary shadow mb-4">
  <div class="card-header py-3">
    <?php if (!$editMode) {
      $activeTab = 'personal-information';
      contentTitleWithLink('Employee Information : ' . strtoupper(toName($employee['lname'], $employee['fname'], $employee['mname'], $employee['ext'])), customUri('hrmis', 'Edit Employee Information', $employeeId), 'Edit', 'fa-edit');
    } else {
      $employeeId = $employeeId;
      $employeePhoto = $employee['picture'];
      contentTitleWithLink('Update Employee Information : ' . strtoupper(toName($employee['lname'], $employee['fname'], $employee['mname'], $employee['ext'])), customUri('hrmis', 'Employee Information', $employeeId));
    }

    $pdsProgress = 0;

    if (numRows(employee($employeeId)) > 0) {
      $pdsProgress += 15;
    }

    if (numRows(family($employeeId)) > 0) {
      $pdsProgress += 10;
    }

    if (numRows(educationalBackgrounds($employeeId)) > 0) {
      $pdsProgress += 15;
    }

    if (numRows(eligibilities($employeeId)) > 0) {
      $pdsProgress += 15;
    }

    if (numRows(experiences($employeeId)) > 0) {
      $pdsProgress += 15;
    }

    if (numRows(learningAndDevelopment($employeeId)) > 0) {
      $pdsProgress += 15;
    }

    if (numRows(specialSkills($employeeId)) > 0) {
      $pdsProgress += 5;
    }

    if (numRows(otherInformation($employeeId)) > 0) {
      $pdsProgress += 10;
    }
    ?>

    <div class="progress mt-1" title="<?php echo $pdsProgress; ?>% Complete">
      <div class="progress-bar bg-success" role="progressbar" aria-valuenow="<?php echo $pdsProgress; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $pdsProgress; ?>%"></div>
    </div><!-- .progress -->
  </div>

  <div class="card-body pb-2">
    <ul class="nav nav-tabs mb-3">
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo setActiveNavigation(!isset($activeTab) || $activeTab === 'personal-information'); ?>" href="#personal-information" data-toggle="tab">Personal Information</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo setActiveNavigation(isset($activeTab) && $activeTab === 'family-background'); ?>" href="#family-background" data-toggle="tab">Family Background</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo setActiveNavigation(isset($activeTab) && $activeTab === 'children'); ?>" href="#children" data-toggle="tab">Children</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo setActiveNavigation(isset($activeTab) && $activeTab === 'educational-background'); ?>" href="#educational-background" data-toggle="tab">Educational Background</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo setActiveNavigation(isset($activeTab) && $activeTab === 'civil-service-eligibility'); ?>" href="#civil-service-eligibility" data-toggle="tab">Civil Service Eligibility</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo setActiveNavigation(isset($activeTab) && $activeTab === 'work-experience'); ?>" href="#work-experience" data-toggle="tab">Work Experience</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo setActiveNavigation(isset($activeTab) && $activeTab === 'voluntary-work'); ?>" href="#voluntary-work" data-toggle="tab">Voluntary Work</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo setActiveNavigation(isset($activeTab) && $activeTab === 'learning-development'); ?>" href="#learning-development" data-toggle="tab">Learning &amp; Development</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo setActiveNavigation(isset($activeTab) && $activeTab === 'special-skills'); ?>" href="#special-skills" data-toggle="tab">Special Skills &amp; Hobbies</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo setActiveNavigation(isset($activeTab) && $activeTab === 'recognition'); ?>" href="#recognition" data-toggle="tab">Non-Academic Distinctions / Recognition</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo setActiveNavigation(isset($activeTab) && $activeTab === 'membership'); ?>" href="#membership" data-toggle="tab">Membership in Association / Organization</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo setActiveNavigation(isset($activeTab) && $activeTab === 'other-information'); ?>" href="#other-information" data-toggle="tab">Other Information</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo setActiveNavigation(isset($activeTab) && $activeTab === 'reference'); ?>" href="#reference" data-toggle="tab">References</a>
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