<?php
// pis/dashboard.php
messageAlert($showAlert, $message, $success);
contentTitle('Dashboard');
?>

<div class="row mt-4">
    <?php
    card('Employee Information', customUri('pis', 'Employee Information', $userId), 'fa-user-tie', 'primary');
    card('Service Record', customUri('pis', 'Service Record', $userId), 'fa-file-alt', 'success');
    card('201 Files', customUri('pis', '201 Files', $userId), 'fa-folder-open', 'info');
    card('Trainings', customUri('pis', 'Trainings', $userId), 'fa-chalkboard-teacher', 'warning');
    card('Payslips', customUri('pis', 'Payslips', $userId), 'fa-money-check', 'danger');
    if (!$isNonDivision) {
        card('IPCRF', customUri('pis', 'IPCRF', $userId), 'fa-chart-line', 'secondary');
        card('Purchase Requests', customUri('pis', 'Purchase Requests'), 'fa-shopping-cart', 'primary');
        card('Booking & Schedule', customuri('bsa', 'Booking & Schedule'), 'fa-calendar-check', 'success');
    }
    ?>
</div>

<?php if ($isNonDivision): ?>
    <hr class="mt-0">
    <div class="row mt-4">
        <?php
        card('Request Transfer', customUri('pis', 'Request Transfer'), 'fa-exchange-alt', 'primary');
        ?>
    </div>
<?php endif; ?>

<?php if ($showMonitoringTools || $showOverview || $showCfsManagement): ?>
    <hr class="mt-0">
    <div class="row mt-4">
        <?php
        if ($showCfsManagement) {
            card('Call for Submissions', customUri('primedx', 'Call for Submissions'), 'fa-inbox', 'primary');
        }

        if ($isSchoolHead) {
            card('My Submissions', customUri('primedx', 'My Submissions'), 'fa-paper-plane', 'primary');
            card('School Employees', customUri('pis', 'School Employees'), 'fa-users', 'success');
        }

        if ($showMonitoringTools) {
            card('Monitoring Tools', customUri('pis', 'Monitoring Tools'), 'fa-binoculars', 'info');
        }
        if ($showOverview) {
            card('HRM Suite', uri() . '/hrmsuite', 'fa-network-wired', 'danger');
        } ?>
    </div>
<?php endif; ?>
