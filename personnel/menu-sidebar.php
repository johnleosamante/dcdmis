<?php
# personnel/sidebar-menu.php
?>

<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">
	<a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo GetSiteURL(); ?>/personnel">
		<div class="sidebar-brand-icon">
			<img src="<?php echo $image; ?>" width="65" height="65">
		</div>
		<div class="sidebar-brand-text mx-3"><?php echo GetSiteAlias(); ?></div>
	</a>

	<hr class="sidebar-divider my-0">

	<li class="nav-item<?php echo SetActiveNavigationItem(!isset($link) || $link === 'Dashboard'); ?>"><a class="nav-link" href="<?php echo GetSiteURL(); ?>/personnel"><i class="fas fa-fw fa-tachometer-alt"></i><span>Dashboard</span></a></li>

	<hr class="sidebar-divider my-0">

	<li class="nav-item<?php echo SetActiveNavigationItem($page === 'Certificates'); ?>">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCertificates" aria-expanded="true" aria-controls="collapseCertificates">
			<i class="fas fa-certificate fa-fw"></i><span>Certificates</span>
		</a>

		<div id="collapseCertificates" class="collapse" aria-labelledby="headingCertificates" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<a class="collapse-item" href="<?php echo GetHashURL('personnel', 'Certificates', 'Division'); ?>">Division Level</a>
				<a class="collapse-item" href="<?php echo GetHashURL('personnel', 'Certificates', 'Regional'); ?>">Regional Level</a>
				<a class="collapse-item" href="<?php echo GetHashURL('personnel', 'Certificates', 'Central'); ?>">Central Level</a>
			</div>
		</div><!-- #collapseCertificates -->
	</li>

	<li class="nav-item<?php echo SetActiveNavigationItem($page === 'Payslip'); ?>"><a class="nav-link" href="<?php echo GetHashURL('personnel', 'Payslip'); ?>"><i class="fas fa-money-check fa-fw"></i><span>Payslip</span></a></li>

	<li class="nav-item<?php echo SetActiveNavigationItem($page === 'Trainings'); ?>"><a class="nav-link" href="<?php echo GetHashURL('personnel', 'Trainings'); ?>"><i class="fas fa-chalkboard-teacher fa-fw"></i><span>Trainings</span></a></li>

	<hr class="sidebar-divider d-none d-md-block">

	<div class="text-center d-none d-md-inline">
		<button class="rounded-circle border-0" id="sidebarToggle"></button>
	</div>
</ul>