<?php
// primedx/dashboard.php
messageAlert($showAlert, $message, $success);
contentTitle('Dashboard');

$allCalls = callForSubmissions();
$openCalls = array_filter($allCalls, static fn($c) => !(bool) $c['is_closed']);
?>

<div class="row mt-4">
    <?php
    if ($canManageCfs) {
        card('Call for Submissions', customUri('primedx', 'Call for Submissions'), 'fa-inbox', 'primary', count($allCalls));
        card('Open Calls', customUri('primedx', 'Call for Submissions'), 'fa-folder-open', 'success', count($openCalls));
    }

    if ($isSchoolHead) {
        card('My Submissions', customUri('primedx', 'My Submissions'), 'fa-paper-plane', 'primary', count($openCalls));
    }
    ?>
</div>
