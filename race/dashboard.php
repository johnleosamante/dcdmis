<?php
// race/dashboard.php
$nominatorOnly = isNominatorOnly($userId);
$countSchedules = number_format(count(awardSchedules()));
$countNominees = number_format(count(allNominees()));
$countAwards = number_format(count(recognitionAwardsWithCategory()));
$countWinners = number_format(count(awardWinners()));

messageAlert($showAlert, $message, $success);
contentTitleWithModal('Dashboard', uri() . '/modules/race/nominate-reminder-dialog.php', 'Nominate', 'fa-user-plus');
?>

<div class="row mt-4">
    <?php
    if ($isICT || !$nominatorOnly):
        card('Schedule', customUri('race', 'Event Schedules'), 'fa-calendar-plus', 'primary', $countSchedules);
    endif;
    card('Nominees', customUri('race', 'Nominees List'), 'fa-user', 'warning', $countNominees);
    card('Awards', customUri('race', 'Awards List'), 'fa-award', 'danger', $countAwards);
    if ($isICT || !$nominatorOnly):
        card('Winners', customUri('race', 'Winners Lookup'), 'fa-trophy', 'success', $countWinners);
    endif;
    ?>
</div>