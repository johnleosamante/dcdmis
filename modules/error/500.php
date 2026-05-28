<?php
// modules/error/500.php
?>

<div class="text-center py-0">
    <div class="error mx-auto" data-text="500">500</div>
    <p class="lead text-gray-800 mt-1 mb-0">Internal Server Error</p>
    <p class="text-gray-600 mb-4">Sorry, we are experiencing a glitch. Please come back and try again later.</p>

    <?php if (isset($userId)): ?>
        <a href="<?= uri() . '/' . $activeApp ?>" title="Go to dashboard">Go to dashboard</a>
    <?php else: ?>
        <a href="<?= uri() ?>" title="Go to home page">Go to home page</a>
    <?php endif ?>
</div>