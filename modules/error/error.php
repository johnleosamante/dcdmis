<?php
// modules/error/error.php
?>

<div class="text-center py-0">
  <div class="error mx-auto w-100">Ooops!</div>
  <p class="lead text-gray-800 mt-1 mb-0">Unexpected error</p>
  <p class="text-gray-500 mb-4">It seems you have encountered a glitch in the system...</p>

  <?php if (isset($userId)) : ?>
    <a href="<?php echo uri() . '/' . $activeApp; ?>" title="Go to dashboard">Go to dashboard</a>
  <?php else : ?>
    <a href="<?php echo uri(); ?>" title="Go to home page">Go to home page</a>
  <?php endif; ?>
</div>