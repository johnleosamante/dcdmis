<?php
// hrtdms/dashboard.php
messageAlert($showAlert, $message, $success);
contentTitleWithModal('Dashboard', uri() . '/modules/trainings/save-training-dialog.php', 'Add Training', 'fa-plus');
?>

<div class="row mt-4">
	<?php
	card('Scheduled Trainings', customUri('hrtdms', 'Scheduled Trainings'), 'fa-calendar-alt', 'primary', $countScheduled);
	card('Conducted Trainings', customUri('hrtdms', 'Conducted Trainings'), 'fa-chalkboard-teacher', 'success');
	card('Employees', customUri('hrtdms', 'Employees'), 'fa-users', 'info', $countActive);
	card('Districts', customUri('hrtdms', 'Districts'), 'fa-map-marked-alt', 'warning', $districtCount);
	card('Schools', customUri('hrtdms', 'Schools'), 'fa-school', 'danger', $schoolCount);
	card('Sections', customUri('hrtdms', 'Sections'), 'fa-map-signs', 'secondary', $sectionCount);
	?>
</div>