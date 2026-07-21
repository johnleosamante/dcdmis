<?php
// modules/prime-hrm/rnr.php
$userPositionId = null;
if ($isPis) {
    if (!function_exists('position')) {
        require_once(root() . '/includes/database/position.php');
    }
    $userPosition = position($userId);
    $userPositionId = $userPosition['position_id'] ?? null;
}
$isAllowedHigherPosition = $isPis && (in_array($userPositionId, $allowedMonitoringPositions, true) || $isICT);

if (!$isAllowedHigherPosition) {
    require_once(root() . '/modules/error/403.php');
    return;
}

$countSchedules = number_format(count(awardSchedules()));
$countNominees = number_format(count(allNominees()));
$countAwards = number_format(count(recognitionAwardsWithCategory()));
$countWinners = number_format(count(awardWinners()));
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= "{$baseUri}/{$activeApp}" ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= customUri('pis', 'PRIME-HRM') ?>">PRIME-HRM</a></li>
            <li class="breadcrumb-item active">Rewards and Recognition</li>
        </ol>
    </nav>
</div>

<div class="row mt-4">
    <?php
    card('Schedule', customUri('pis', 'Event Schedules'), 'fa-calendar-plus', 'primary', $countSchedules);
    card('Nominees', customUri('pis', 'Nominees List'), 'fa-user', 'warning', $countNominees);
    card('Awards', customUri('pis', 'Awards List'), 'fa-award', 'danger', $countAwards);
    card('Winners', customUri('pis', 'Winners Lookup'), 'fa-trophy', 'success', $countWinners);
    ?>
</div>