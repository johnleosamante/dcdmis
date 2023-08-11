<?php
// includes/layout/header-menu.php
$user = fetchAssoc(employee($userId));
$displayName = toName($user['lname'], $user['fname'], $user['mname'], $user['ext'], true, true);
$position = fetchAssoc(position($userId))['position'];
$displayPhoto = uri() . '/' . $user['picture'];
?>
<nav class="navbar navbar-expand navbar-light bg-white topbar static-top shadow">
  <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
    <i class="fa fa-bars"></i>
  </button>

  <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-0 my-2 my-md-0 mw-100 navbar-search" method="POST" action="">
    <div class="input-group">
      <input type="text" class="form-control bg-light border-0 small" placeholder="Search..." aria-label="Search" name="primary-search-text" autofocus required>
      <div class="input-group-append">
        <button class="btn btn-primary" type="submit" name="primary-search-button">
          <i class="fas fa-search fa-sm"></i>
        </button>
      </div>
    </div>
  </form>

  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown no-arrow d-sm-none">
      <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-search fa-fw"></i>
      </a>

      <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
        <form class="form-inline mr-auto w-100 navbar-search" method="POST" action="">
          <div class="input-group">
            <input type="text" class="form-control bg-light border-0 small" placeholder="Search..." aria-label="Search" name="primary-search-text" required>
            <div class="input-group-append">
              <button class="btn btn-primary" type="submit" name="primary-search-button">
                <i class="fas fa-search fa-sm"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
    </li>

    <li class="nav-item dropdown no-arrow">
      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="<?php echo strtoupper($displayName); ?>">
        <span class="mr-2 d-none d-md-inline">
          <div class="text-gray-600 small"><?php echo strtoupper($displayName); ?></div>
          <div class="text-xs text-gray-500"><?php echo strtoupper($position); ?></div>
        </span>
        <span class="d-flex justify-content-center align-middle img-profile rounded-circle overflow-hidden">
          <img src="<?php echo $displayPhoto; ?>" alt="<?php echo $displayName; ?>" height="100%">
        </span>
      </a>

      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
        <?php
        linkDropdownItem(uri() . '/pis', 'Profile', 'fa-user-tie', 'Personnel Information System');

        if (numRows(dtsUser($userId)) > 0) {
          linkDropdownItem(uri() . '/dts', 'Tracking', 'fa-exchange-alt', 'Document Tracking System');
        }
        
        if (isStationUser($userId, 'hrmis')) {
          linkDropdownItem(uri() . '/hrmis', 'HR Management', 'fa-users', 'Human Resource Management Information System');
        }

        if (isStationUser($userId, 'hrtdms')) {
          linkDropdownItem(uri() . '/hrtdms', 'HR Trainings', 'fa-chalkboard-teacher', 'Human Resource Training &amp; Development Management System');
        }

        if (isStationUser($userId, 'dmis')) {
          linkDropdownItem(uri() . '/dmis', 'Division Management', 'fa-industry', 'Division Management Information System');
        }
        ?>

        <div class="dropdown-divider"></div>
        
        <?php linkDropdownItem(customUri($activeApp, 'Activity Log'), 'Activity Log', 'fa-list', 'View activity log');

        linkDropdownItem(customUri($activeApp, 'Settings'), 'Settings', 'fa-cogs', 'Go to settings');
        ?>
        <div class="dropdown-divider"></div>
        <?php modalDropdownItem(uri() . '/logout/logout-dialog.php', 'Logout', 'fa-sign-out-alt', 'Logout', 'text-danger'); ?>
      </div>
    </li>
  </ul>
</nav>

<div class="background-cover banner text-uppercase text-gray-700">
  <?php
  $schools = schoolDetailsById($stationId);
  if (numRows($schools)) {
    $school = fetchAssoc($schools);
  ?>
    <div class="h3 m-0"><?php echo $school['name']; ?></div>
    <?php if (!empty($school['address'])) : ?>
      <div class="small m-0"><?php echo $school['address']; ?></div>
    <?php endif;
  }

  if ($hasPortal && !$isSchoolPortal) : ?>
    <div id="station-name" class="h2 mt-4 m-0"><?php echo stationName($station); ?></div>
  <?php endif; ?>
</div>