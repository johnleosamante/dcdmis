<?php
// modules/error/not-found.php
?>

<div class="text-center pt-5">
  <div class="error mx-auto" data-text="403">403</div>
  <p class="lead text-gray-800 mb-0">Access denied</p>
  <p class="text-gray-500 mb-4">Sorry, the page you're trying to access is restricted.</p>

  <?php if (isset($_SESSION[alias() . '_user_id'])) : ?>
    <a href="<?php echo uri() . '/' . $_SESSION[alias() . '_active_app']; ?>" title="Go back to dashboard">Go back to Dashboard</a>
  <?php endif; ?>
</div>