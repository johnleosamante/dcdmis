<?php
// includes/database/activity.php
// tbl_calendar_of_activity
function hasHoliday() {
  return numRows(query("SELECT `No` FROM `tbl_calendar_of_activity` WHERE (`EndDate` >= CURDATE() AND `StartDate` <= CURDATE()) AND `isHoliday`=1;")) > 0;
}
?>