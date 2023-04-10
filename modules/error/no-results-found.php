<?php
// modules/error/not-found.php
?>

<div class="text-center pt-5">
  <div class="error mx-auto"><i class="fas fa-search fa-fw"></i></div>
  <p class="lead text-gray-800 mb-0">No results found</p>
  <p class="text-gray-500 mb-4">Sorry, we couldn't find what you're looking for...</p>
  <a href="<?php echo uri() . '/' . $_SESSION[alias() . '_active_app']; ?>" title="Go back to dashboard">Back to Dashboard</a>
</div>