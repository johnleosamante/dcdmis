<?php
if (!$isPis) {
    require_once(root() . '/modules/error/403.php');
    return;
}

$employeeId = (int) sanitize(decode($_GET['id'] ?? null));

if ($userId !== $employeeId || !employee($employeeId)) {
    require_once(root() . '/modules/error/no-results-found.php');
    return;
}
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Performance Management</li>
        </ol>
    </nav>
</div>

<?php contentTitle('Performance Management') ?>
