<?php
// pis/page.php
messageAlert($showAlert, $message, $success);
contentTitle('Dashboard');
?>

<div class="row mt-4">
    <?php
    card('Employee Information', customUri('pis', 'Employee Information', $userId), 'fa-user-tie', 'primary');
    card('Service Record', customUri('pis', 'Service Record', $userId), 'fa-file-alt', 'success');
    card('201 Files', customUri('pis', '201 Files', $userId), 'fa-folder-open', 'info');
    card('Trainings', customUri('pis', 'Trainings', $userId), 'fa-chalkboard-teacher', 'warning');
    card('Payslip', customUri('pis', 'Payslip', $userId), 'fa-money-check', 'danger');
    ?>
</div>

<?php
if (!$isNonDivision && ($showMonitoringTools || $showOverview)): ?>
    <hr class="mt-0">
    <div class="row mt-4">
        <?php
        if ($showMonitoringTools) {
            card('Monitoring Tools', customUri('pis', 'Monitoring Tools'), 'fa-binoculars', 'primary');
        }
        if ($showOverview) {
            card('System Overview', customUri('pis', 'System Overview'), 'fa-network-wired', $showMonitoringTools ? 'success' : 'primary');
        } ?>
    </div>
<?php endif;

$schoolInfo = schoolByHead($userId);
if ($schoolInfo): ?>
    <hr class="mt-0">
    <div class="row mt-4">
        <?php
        card('School Employees', customUri('pis', 'School Employees'), 'fa-users', 'primary');
        if ($isSchoolPortal || $isNonDivision) {
            card('Request Transfer', customUri('pis', 'Request Transfer'), 'fa-exchange-alt', 'success');
        } ?>
    </div>
<?php endif;