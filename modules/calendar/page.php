<?php
// modules/calendar/page.php
messageAlert($showAlert, $message, $success);
?>

<div id="calendar-panel" class="card">
  <div class="card-header text-uppercase text-center font-weight-bold">
    Calendar of Activities
  </div>

  <div id="calendar" class="card-body">
    <?php
    $calendarActivities = calendar();

    if (numRows($calendarActivities) === 0) { ?>
      <div class="text-center">No scheduled activities</div>
    <?php } else { ?>
      <ul class="fa-ul mb-0 ml-4">
        <?php while ($calendar = fetchAssoc($calendarActivities)) { ?>
          <li class="py-1">
            <?php $isHoliday = $calendar['isHoliday']; ?>
            <span class="fa-li">
              <i class="fas fa-calendar-alt <?php echo $isHoliday ? 'text-danger' : 'text-primary'; ?>"></i>
            </span>

            <span class="<?php echo $isHoliday ? 'text-danger' : 'text-primary'; ?>">
              <?php echo $calendar['activity']; ?>
            </span>

            <?php
            $from = strtotime($calendar['from']);
            $to = strtotime($calendar['to']);
            $sameDay = $from === $to;
            $sameYear = date('Y', $from) === date('Y', $to);
            $sameMonth = date('m', $from) === date('m', $to);

            if ($sameDay) {
              $date = date('F j, Y', strtotime($calendar['from']));
            } elseif ($sameYear && $sameMonth) {
              $date = date('F j', $from) . '-' . date('j, Y', $to);
            } elseif ($sameYear && !$sameMonth) {
              $date = date('M j', $from) . ' - ' . date('M j, Y', $to);
            } else {
              $date = date('M j, Y', $from) . ' - ' . date('M j, Y', $to);
            }
            ?>
            <div class="small"><?php echo $date; ?></div>
          </li>
        <?php } ?>
      </ul>
    <?php } ?>
  </div>
</div>