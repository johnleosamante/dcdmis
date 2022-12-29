<?php
# personnel/dashboard.php

ContentTitle('Dashboard'); ?>

<div class="row my-3">
<?php
Card('Daily Time Record', GetHashURL('personnel', 'Daily Time Record'), 'fa-clock', 'primary');
Card('Service Record', GetHashURL('personnel', 'Service Record'), 'fa-file-alt', 'success');
Card('Personal Data Sheet', GetHashURL('personnel', 'Personal Data Sheet'), 'fa-user', 'info');
Card('Locator', GetHashURL('personnel', 'Locator'), 'fa-search-location', 'warning');
Card('Transfer Request', GetHashURL('personnel', 'Transfer Request'), 'fa-map', 'danger');
Card('DepEd Account Request', GetHashURL('personnel', 'DepEd Account Request'), 'fa-edit', 'secondary');
Card('IPCRF', GetHashURL('personnel', 'IPCRF'), 'fa-tasks', 'primary');
Card('201 File', GetHashURL('personnel', '201 File'), 'fa-book-open', 'success');
?>
</div>