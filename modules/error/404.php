<?php
// modules/error/not-found.php
?>

<div class="text-center pt-5">
  <div class="error mx-auto" data-text="404">404</div>
  <p class="lead text-gray-800 mb-0">Page not found</p>
  <p class="text-gray-500 mb-4">Sorry, we couldn't find what you're looking for...</p>

  <?php if (isset($_SESSION[alias() . '_user_id'])) : ?>
    <a href="<?php echo uri() . '/' . $_SESSION[alias() . '_active_app']; ?>" title="Go back to dashboard">Go back to Dashboard</a>
  <?php endif; ?>
</div>