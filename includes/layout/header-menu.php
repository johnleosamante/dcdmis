<?php
// includes/layout/header-menu.php
$user = fetch_assoc(employee($user_id));
$display_name = to_name($user['lname'], $user['fname'], $user['mname'], $user['ext'], true, true);
$display_photo = uri() . '/' . $user['picture'];
?>
<nav class="navbar navbar-expand navbar-light bg-white topbar static-top shadow">
  <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
    <i class="fa fa-bars"></i>
  </button>

  <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-0 my-2 my-md-0 mw-100 navbar-search" method="POST" action="">
    <div class="input-group">
      <input type="text" class="form-control bg-light border-0 small" placeholder="Search..." aria-label="Search" name="primary_search_text" autofocus required>
      <div class="input-group-append">
        <button class="btn btn-primary" type="submit" name="primary_search_button">
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
            <input type="text" class="form-control bg-light border-0 small" placeholder="Search..." aria-label="Search" name="primary_search_text" required>
            <div class="input-group-append">
              <button class="btn btn-primary" type="submit" name="primary_search_button">
                <i class="fas fa-search fa-sm"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
    </li>

    <li class="nav-item dropdown no-arrow">
      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="<?php echo strtoupper($display_name); ?>">
        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo strtoupper($display_name); ?></span>
        <span class="img-profile rounded-circle overflow-hidden">
          <img src="<?php echo $display_photo; ?>" alt="<?php echo $display_name; ?>" width="100%">
        </span>
      </a>

      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
        <?php
        link_dropdown_item(uri() . '/pis', 'Profile', 'fa-user', 'Go to user profile');
        link_dropdown_item(custom_uri('dts', 'Settings'), 'Settings', 'fa-cogs', 'Go to settings');
        link_dropdown_item(custom_uri('dts', 'Activity Log'), 'Activity Log', 'fa-list', 'View activity log');
        ?>
        <div class="dropdown-divider"></div>
        <?php modal_dropdown_item(uri() . '/logout/logout-dialog.php', 'Logout', 'fa-sign-out-alt', 'Logout', 'text-danger'); ?>
      </div>
    </li>
  </ul>
</nav>

<div class="banner text-uppercase text-gray-700">
  <?php
  $schools = school_details_by_id($station_id);
  if (num_rows($schools)) {
    $school = fetch_assoc($schools);
  ?>
    <div class="h3 m-0"><?php echo $school['name']; ?></div>
    <?php if (!empty($school['address'])) : ?>
      <div class="small m-0"><?php echo $school['address']; ?></div>
    <?php endif;
  }

  if ($portal !== 'school_portal') : ?>
    <div class="h2 mt-4 m-0"><?php echo station_name($code); ?></div>
  <?php endif; ?>
</div>