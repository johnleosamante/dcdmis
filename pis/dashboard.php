<?php
// pis/page.php
messageAlert($showAlert, $message, $success);
contentTitle('Dashboard');

$schoolInfo = schoolByHead($userId);
$canSeeMonitoring = $showMonitoringTools || (bool) $schoolInfo;
?>

<div class="row mt-4">
    <?php
    card('Employee Information', customUri('pis', 'Employee Information', $userId), 'fa-user-tie', 'primary');
    card('Service Record', customUri('pis', 'Service Record', $userId), 'fa-file-alt', 'success');
    card('201 Files', customUri('pis', '201 Files', $userId), 'fa-folder-open', 'info');
    card('Trainings', customUri('pis', 'Trainings', $userId), 'fa-chalkboard-teacher', 'warning');
    card('Payslip', customUri('pis', 'Payslip', $userId), 'fa-money-check', 'danger');
    card('IPCRF', customUri('pis', 'IPCRF', $userId), 'fa-chart-line', 'secondary');
    ?>
</div>

<?php if (!$isNonDivision && ($canSeeMonitoring || $showOverview)): ?>
    <hr class="mt-0">
    <div class="row mt-4">
        <?php
        if ($canSeeMonitoring) {
            card('Monitoring Tools', customUri('pis', 'Monitoring Tools'), 'fa-binoculars', 'primary');
        }
        if ($showOverview) {
            card('System Overview', customUri('pis', 'System Overview'), 'fa-network-wired', $canSeeMonitoring ? 'success' : 'primary');
        } ?>
    </div>
<?php endif; ?>

<?php if ($schoolInfo): ?>
    <hr class="mt-0">
    <div class="row mt-4">
        <?php
        card('School Employees', customUri('pis', 'School Employees'), 'fa-users', 'primary');

        if ($isSchoolPortal || $isNonDivision) {
            card('Request Transfer', customUri('pis', 'Request Transfer'), 'fa-exchange-alt', 'success');
        }
        ?>
    </div>
<?php endif; ?>