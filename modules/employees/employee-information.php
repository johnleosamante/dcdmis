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
    <div class="row">
      <div class="col-md-6 col-lg-3 col-xl-2 justify-content-center">
        <img src="<?php echo uri() . '/' . $employee['picture']; ?>" width="100%" class="border rounded mb-4">
      </div>
      <div class="col-md-6 col-lg-9 col-xl-10 table-responsive">
        <table cellspacing="0">
          <tbody>
            <tr>
              <th class="py-2">Last Name:</th>
              <td class="py-2 pl-3" colspan="7">Last</td>
            </tr>
            <tr>
              <th class="py-2">First Name:</th>
              <td class="py-2 pl-3 pr-5" colspan="5">First</td>
              <th class="py-2">Extension:</th>
              <td class="py-2 pl-3">Extension</td>
            </tr>
            <tr>
              <th class="py-2">Middle Name:</th>
              <td class="py-2 pl-3" colspan="7">Middle</td>
            </tr>
            <tr>
              <th class="py-2">Date of Birth:</th>
              <td class="py-2 pl-3 pr-5">Date</td>
              <th class="py-2" colspan="1">Place of Birth:</th>
              <td class="py-2 pl-3" colspan="5">Place</td>
            </tr>
            <tr>
              <th class="py-2">Sex:</th>
              <td class="py-2 pl-3 pr-5">Sex</td>
              <th class="py-2">Civil Status:</th>
              <td class="py-2 pl-3 pr-5">Civil Status</td>
              <th class="py-2">Position:</th>
              <td class="py-2 pl-3 pr-5">Position</td>
              <th class="py-2">Station:</th>
              <td class="py-2 pl-3">Station</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div><!-- .row -->

    <ul class="nav nav-tabs mb-3">
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo set_active_navigation(!isset($_SESSION[alias() . '_employee_tab']) || $_SESSION[alias() . '_employee_tab'] === 'personal-information'); ?>" href="#personal-information" data-toggle="tab">Personal Information</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo set_active_navigation(isset($_SESSION[alias() . '_employee_tab']) && $_SESSION[alias() . '_employee_tab'] ===  'family-background'); ?>" href="#family-background" data-toggle="tab">Family Background</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo set_active_navigation(isset($_SESSION[alias() . '_employee_tab']) && $_SESSION[alias() . '_employee_tab'] === 'children'); ?>" href="#children" data-toggle="tab">Children</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo set_active_navigation(isset($_SESSION[alias() . '_employee_tab']) && $_SESSION[alias() . '_employee_tab'] === 'educational-background'); ?>" href="#educational-background" data-toggle="tab">Educational Background</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo set_active_navigation(isset($_SESSION[alias() . '_employee_tab']) && $_SESSION[alias() . '_employee_tab'] === 'eligibility'); ?>" href="#eligibility" data-toggle="tab">Civil Service Eligibility</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo set_active_navigation(isset($_SESSION[alias() . '_employee_tab']) && $_SESSION[alias() . '_employee_tab'] === 'work-experience'); ?>" href="#work-experience" data-toggle="tab">Work Experience</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo set_active_navigation(isset($_SESSION[alias() . '_employee_tab']) && $_SESSION[alias() . '_employee_tab'] === 'voluntary-work'); ?>" href="#voluntary-work" data-toggle="tab">Voluntary Work</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo set_active_navigation(isset($_SESSION[alias() . '_employee_tab']) && $_SESSION[alias() . '_employee_tab'] === 'learning-development'); ?>" href="#learning-development" data-toggle="tab">Learning and Development</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo set_active_navigation(isset($_SESSION[alias() . '_employee_tab']) && $_SESSION[alias() . '_employee_tab'] === 'special-skills'); ?>" href="#special-skills" data-toggle="tab">Special Skills &amp; Hobbies</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo set_active_navigation(isset($_SESSION[alias() . '_employee_tab']) && $_SESSION[alias() . '_employee_tab'] === 'recognition'); ?>" href="#recognition" data-toggle="tab">Non-Academic Distinctions / Recognition</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo set_active_navigation(isset($_SESSION[alias() . '_employee_tab']) && $_SESSION[alias() . '_employee_tab'] === 'membership'); ?>" href="#membership" data-toggle="tab">Membership in Association / Organization</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo set_active_navigation(isset($_SESSION[alias() . '_employee_tab']) && $_SESSION[alias() . '_employee_tab'] === 'other-information'); ?>" href="#other-information" data-toggle="tab">Other Information</a>
      </li><!-- .nav-item -->
      <li class="nav-item">
        <a class="nav-link text-secondary<?php echo set_active_navigation(isset($_SESSION[alias() . '_employee_tab']) && $_SESSION[alias() . '_employee_tab'] === 'reference'); ?>" href="#reference" data-toggle="tab">References</a>
      </li><!-- .nav-item -->
    </ul><!-- .nav-tabs -->

    <div class="tab-content mt-2">
      <?php
      include_once(root() . '/modules/employees/view/personal-information.php');
      // include_once(root() . '/modules/employees/view/family-background.php');
      // include_once(root() . '/modules/employees/view/children.php');
      // include_once(root() . '/modules/employees/view/educational-background.php');
      // include_once(root() . '/modules/employees/view/civil-service-eligibility.php');
      // include_once(root() . '/modules/employees/view/work-experience.php');
      // include_once(root() . '/modules/employees/view/voluntary-work.php');
      // include_once(root() . '/modules/employees/view/learning-development.php');
      // include_once(root() . '/modules/employees/view/special-skills.php');
      // include_once(root() . '/modules/employees/view/recognition.php');
      // include_once(root() . '/modules/employees/view/membership.php');
      // include_once(root() . '/modules/employees/view/other-information.php');
      // include_once(root() . '/modules/employees/view/reference.php');
      ?>
    </div><!-- .tab-content -->
  </div><!-- .card-body -->
</div><!-- .card -->