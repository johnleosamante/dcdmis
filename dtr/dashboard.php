<?php
// pis/page.php
messageAlert($showAlert, $message, $success);
contentTitle('Dashboard');
?>

<div class="row mt-4">
    <?php
    card('Daily Time Record', customUri('dtr', 'Daily Time Record', $userId), 'fa-clock', 'primary');
    ?>
</div>