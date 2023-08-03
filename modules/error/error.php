<?php
// modules/error/error.php
$isRestricted = isWeekend() || !isOfficialTime() || $isHoliday;
?>

<div class="text-center py-0">
  <div class="error mx-auto w-100">Oops!</div>
  <p class="lead text-gray-800 mt-1 mb-0"><?php echo $isRestricted ? 'Restricted Access' : 'Unexpected error'; ?></p>
  <p class="text-gray-500 mb-4"><?php echo $isRestricted ? 'It seems that the system is currently not accessible...' : 'It seems you have encountered a glitch in the system...'; ?></p>

  <?php if (!$isRestricted && isset($userId)) { ?>
    <a href="<?php echo uri() . '/' . $activeApp; ?>" title="Go to dashboard">Go to dashboard</a>
  <?php } else { ?>
    <a href="<?php echo uri(); ?>" title="Go to home page">Go to home page</a>
  <?php } ?>
</div>