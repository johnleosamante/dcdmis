<?php
# personnel/dashboard.php

ContentTitle('Dashboard'); ?>

<div class="row my-3">
<?php
Card('Service Record', GetHashURL('personnel', 'Service Record'), 'fa-file-alt');
Card('Personal Data Sheet', GetHashURL('personnel', 'Personal Data Sheet'), 'fa-user', 'success');
Card('Locator', GetHashURL('personnel', 'Locator'), 'fa-search-location', 'info');
Card('Transfer Request', GetHashURL('personnel', 'Transfer Request'), 'fa-map', 'warning');
Card('DepEd Account Request', GetHashURL('personnel', 'DepEd Account Request'), 'fa-edit', 'danger');
Card('IPCRF', GetHashURL('personnel', 'IPCRF'), 'fa-tasks', 'secondary');
Card('201 File', GetHashURL('personnel', '201 File'), 'fa-book-open', 'primary');
?>
</div>