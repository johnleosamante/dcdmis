<?php
// modules/error/403.php
?>

<div class="text-center py-0">
    <div class="error mx-auto" data-text="403">403</div>
    <p class="lead text-gray-800 mt-1 mb-0"><?= isset($csrfError) ? 'Session / Token Error' : 'Access Denied' ?></p>
    <p class="text-gray-600 mb-4">
        <?= isset($csrfError) ? e($csrfError) : "Sorry, the page you're trying to access is restricted." ?></p>

    <div class="d-flex justify-content-center gap-2">
        <button type="button" onclick="window.history.back();" class="btn btn-outline-secondary btn-sm px-3 mr-2">
            <i class="fas fa-arrow-left mr-1"></i> Go Back
        </button>
        <?php if (isset($userId)): ?>
            <a href="<?= uri() . '/' . $activeApp ?>" class="btn btn-primary btn-sm px-3" title="Go to dashboard">
                <i class="fas fa-home mr-1"></i> Go to Dashboard
            </a>
        <?php else: ?>
            <a href="<?= uri() ?>" class="btn btn-primary btn-sm px-3" title="Go to home page">
                <i class="fas fa-home mr-1"></i> Go to Home Page
            </a>
        <?php endif ?>
    </div>
</div>