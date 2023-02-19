<?php
# personnel/pds.php
?>

<div class="row mt-4 mb-4">
  <div class="col">
    <div class="card">
      <div class="card-header">
        <h3 class="h4 mb-2">Personal Data Sheet (<?php echo $pds_progress; ?>% Complete)</h3>

        <div class="progress">
          <div class="progress-bar bg-success" role="progressbar" aria-valuenow="<?php echo $pds_progress; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $pds_progress; ?>%"></div>
        </div><!-- .progress -->
      </div><!-- .card-header -->

      <div class="card-body">
        <ul class="nav nav-tabs mb-3">
          <li class="nav-item">
            <a class="nav-link text-secondary<?php echo SetActiveNavigationItem(!isset($_SESSION['pdstab']) || $_SESSION['pdstab'] === 'personal-information'); ?>" href="#personal-information" data-toggle="tab">Personal Information</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-secondary<?php echo SetActiveNavigationItem(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'family-background'); ?>" href="#family-background" data-toggle="tab">Family Background</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-secondary<?php echo SetActiveNavigationItem(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'children'); ?>" href="#children" data-toggle="tab">Children</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-secondary<?php echo SetActiveNavigationItem(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'educational-background'); ?>" href="#educational-background" data-toggle="tab">Educational Background</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-secondary<?php echo SetActiveNavigationItem(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'eligibility'); ?>" href="#eligibility" data-toggle="tab">Civil Service Eligibility</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-secondary<?php echo SetActiveNavigationItem(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'work-experience'); ?>" href="#work-experience" data-toggle="tab">Work Experience</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-secondary<?php echo SetActiveNavigationItem(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'voluntary-work'); ?>" href="#voluntary-work" data-toggle="tab">Voluntary Work</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-secondary<?php echo SetActiveNavigationItem(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'learning-development'); ?>" href="#learning-development" data-toggle="tab">Learning and Development</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-secondary<?php echo SetActiveNavigationItem(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'special-skills'); ?>" href="#special-skills" data-toggle="tab">Special Skills &amp; Hobbies</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-secondary<?php echo SetActiveNavigationItem(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'recognition'); ?>" href="#recognition" data-toggle="tab">Non-Academic Distinctions / Recognition</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-secondary<?php echo SetActiveNavigationItem(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'membership'); ?>" href="#membership" data-toggle="tab">Membership in Association / Organization</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-secondary<?php echo SetActiveNavigationItem(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'other-information'); ?>" href="#other-information" data-toggle="tab">Other Information</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-secondary<?php echo SetActiveNavigationItem(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'reference'); ?>" href="#reference" data-toggle="tab">References</a>
          </li>
        </ul>

        <?php
        if ($showPrompt) {
          AlertBox($message, $success ? 'success' : 'danger', 'left');
        }
        ?>

        <div class="tab-content mt-2">
          <?php
          include_once('pds/personal-information.php');
          include_once('pds/family-background.php');
          include_once('pds/children.php');
          include_once('pds/educational-background.php');
          include_once('pds/civil-service-eligibility.php');
          include_once('pds/work-experience.php');
          include_once('pds/voluntary-work.php');
          include_once('pds/learning-development.php');
          include_once('pds/special-skills.php');
          include_once('pds/recognition.php');
          include_once('pds/membership.php');
          include_once('pds/other-information.php');
          include_once('pds/reference.php');
          ?>
        </div>
      </div><!-- .card-body -->
    </div><!-- .card -->
  </div><!-- .col -->
</div><!-- .row -->

<div class="modal fade" id="Modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true" data-backdrop="static"></div><!-- .modal -->