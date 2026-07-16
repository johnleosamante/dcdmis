<?php
// modules/dtr/page.php
if (!$isPis && !$isDtr) {
    require_once(root() . '/modules/error/403.php');
    return;
}

$employeeId = (int) sanitize(decode($_GET['id'] ?? null));

if ($userId !== $employeeId) {
    require_once(root() . '/modules/error/no-results-found.php');
    return;
}

$employee = employee($employeeId);

if ($employee) {
    $employeeId = $employee['id'];
} else {
    require_once(root() . '/modules/error/no-results-found.php');
    return;
}

messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Daily Time Record</li>
        </ol>
    </nav>
</div>

<div class="card border-left-info shadow mb-4">
    <div class="card-header py-3">
        <?php contentTitleWithLink('Daily Time Record : ' . strtoupper(toName($employee['last_name'], $employee['first_name'], $employee['middle_name'], $employee['name_extension'])), uri() . '/' . $activeApp) ?>
    </div>

    <div class="card-body">
        <div class="text-center py-5">
            <i class="fas fa-clock fa-4x text-info mb-3"></i>
            <h4 class="text-gray-800">Daily Time Record</h4>
            <p class="text-gray-600 mb-0">Daily Time Record details will appear here.</p>
        </div>
    </div>
</div>
