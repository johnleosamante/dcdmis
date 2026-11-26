<?php
// modules/overview/page.php
if (!$isHrmSuite) {
    require_once(root() . '/modules/error/403.php');
    return;
}

contentTitle('System Overview');
?>

<div class="row mt-4">
    <?php
    card('Recruitment, Selection and Placement', customUri('hrmsuite', 'Recruitment, Selection and Placement'), 'fa-user-check');
    card('Learning and Development', customUri('hrmsuite', 'Learning and Development'), 'fa-chalkboard-teacher', 'success');
    card('Performance Management', customUri('hrmsuite', 'Performance Management'), 'fa-chart-line', 'info');
    card('Rewards and Recognition', customUri('hrmsuite', 'Rewards and Recognition'), 'fa-trophy', 'warning');
    ?>
</div>
