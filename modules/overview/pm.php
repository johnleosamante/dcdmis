<?php
// modules/prime-hrm/pm.php
if (!$isPis) {
    require_once(root() . '/modules/error/403.php');
    return;
}
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= "{$baseUri}/{$activeApp}" ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= customUri('pis', 'PRIME-HRM') ?>">PRIME-HRM</a></li>
            <li class="breadcrumb-item active">Performance Management</li>
        </ol>
    </nav>
</div>