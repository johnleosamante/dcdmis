<?php
# personnel/dashboard.php

ContentTitle('Dashboard'); ?>

<div class="row my-3">
<?php
Card('Daily Time Record', GetHashURL('personnel', 'Daily Time Record'), 'fa-clock', 'primary');
Card('Personal Data Sheet', GetHashURL('personnel', 'Personal Data Sheet'), 'fa-user', 'success');
Card('Service Record', GetHashURL('personnel', 'Service Record'), 'fa-file-alt', 'info');
Card('201 File', GetHashURL('personnel', '201 File'), 'fa-book-open', 'warning');
Card('IPCRF', GetHashURL('personnel', 'IPCRF'), 'fa-tasks', 'danger');
Card('Certificates', GetHashURL('personnel', 'Certificates', 'All'), 'fa-certificate', 'secondary');
Card('Trainings', GetHashURL('personnel', 'Trainings'), 'fa-chalkboard-teacher', 'primary');
Card('Payslip', GetHashURL('personnel', 'Payslip'), 'fa-money-check', 'success');
Card('DepEd Account Request', GetHashURL('personnel', 'DepEd Account Request'), 'fa-edit', 'info');
Card('Locator', GetHashURL('personnel', 'Locator'), 'fa-search-location', 'warning');
Card('Transfer Request', GetHashURL('personnel', 'Transfer Request'), 'fa-map', 'danger');
?>
</div>