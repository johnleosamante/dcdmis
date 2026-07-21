<?php
// modules/prime-hrm/rsp.php
if (!$isPis) {
    require_once(root() . '/modules/error/403.php');
    return;
}

require_once(root() . '/includes/database/vacancy.php');

$countActive = number_format(countActiveEmployees());
$countRetirable = number_format(countRetirableEmployees());
$countVacancy = number_format(countVacantItems());
$countPublications = number_format(countPublications());
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= "{$baseUri}/{$activeApp}" ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= customUri('pis', 'PRIME-HRM') ?>">PRIME-HRM</a></li>
            <li class="breadcrumb-item active">Recruitment, Selection and Placement</li>
        </ol>
    </nav>
</div>

<div class="row mt-4">
    <?php
    card('Talent Pool', customUri('pis', 'Talent Pool Diversity - Gender'), 'fa-chart-bar');
    card('Workforce', customUri('pis', 'Workforce Diversity - Gender'), 'fa-chart-pie', 'success');
    card('Active Employees', customUri('pis', 'Active Employees'), 'fa-user-check', 'info', $countActive);
    card('Retirable Employees', customUri('pis', 'Retirable Employees'), 'fa-user-clock', 'warning', $countRetirable);
    card('Vacancies', customUri('pis', 'Vacancies'), 'fa-user-times', 'danger', $countVacancy);
    card('Call for Applications', customUri('pis', 'Call for Applications'), 'fa-bullhorn', 'secondary', $countPublications);
    card('Positions', customUri('pis', 'Positions'), 'fa-user-tie', 'primary');
    card('Plantilla Items', customUri('pis', 'Plantilla Items'), 'fa-list', 'success');
    ?>
</div>