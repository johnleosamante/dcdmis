<?php
// prime-hrm/page.php

contentTitle('System Overview');
?>

<div class="row mt-4">
    <?php
    card('Recruitment, Selection and Placement', customUri('pis', 'Recruitment, Selection and Placement'), 'fa-user-check');
    card('Learning and Development', customUri('pis', 'Learning and Development'), 'fa-chalkboard-teacher', 'success');
    card('Performance Management', customUri('pis', 'Performance Management'), 'fa-chart-line', 'info');
    card('Rewards and Recognition', customUri('pis', 'Rewards and Recognition'), 'fa-trophy', 'warning');
    ?>
</div>