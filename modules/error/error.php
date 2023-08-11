<?php
// modules/error/error.php
$isAccessible = !isWeekend() && isOfficialTime() && !$isHoliday;
?>

<div class="text-center py-0">
  <div class="error mx-auto w-100">Oops!</div>
  <p class="lead text-gray-800 mt-1 mb-0"><?php echo $isAccessible ? 'Unexpected error' : 'Restricted Access'; ?></p>
  <p class="text-gray-500 mb-4"><?php echo $isAccessible ? 'It seems you have encountered a glitch in the system...' : 'It seems that the system is currently not accessible...'; ?></p>

  <?php if ($isAccessible && isset($userId)) { ?>
    <a href="<?php echo uri() . '/' . $activeApp; ?>" title="Go to dashboard">Go to dashboard</a>
  <?php } else { ?>
    <a href="<?php echo uri(); ?>" title="Go to home page">Go to home page</a>
  <?php } ?>
</div>