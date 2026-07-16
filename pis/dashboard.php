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
    
    $schoolInfo = schoolByHead($userId);
    if ($schoolInfo) {
        card('School Employees', customUri('pis', 'Employees'), 'fa-users', 'secondary');
    }
    
    card('Performance Management', customUri('pis', 'Performance Management', $userId), 'fa-money-check', 'secondary');
    card('Daily Time Record', customUri('pis', 'Daily Time Record', $userId), 'fa-money-check', 'dark');
    ?>
</div>