<?php
// hrmpsb/dashboard.php
messageAlert($showAlert, $message, $success);
contentTitleWithModal('Dashboard', uri() . '/modules/vacancies/save-vacancy-dialog.php', 'Add Vacancy', 'fa-plus');
?>

<div class="row mt-4">
    <?php
    card('Active Employees', customUri('hrmpsb', 'Active Employees'), 'fa-user-check', 'primary', $countActive);
    card('Retirable Employees', customUri('hrmpsb', 'Retirable Employees'), 'fa-user-clock', 'success', $countRetirable);
    card('Districts', customUri('hrmpsb', 'Districts'), 'fa-map-marked-alt', 'info', $districtCount);
    card('Schools', customUri('hrmpsb', 'Schools'), 'fa-school', 'warning', $schoolCount);
    card('Open Vacancies', customUri('hrmpsb', 'Vacancies'), 'fa-door-open', 'danger', $countOpenVacancies);
    card('Publications', customUri('hrmpsb', 'Publications'), 'fa-newspaper', 'success', $countPublications);
    ?>
</div>