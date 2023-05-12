<?php
// includes/database/user.php
function user($id) {
  return query("SELECT tbl_user.usercode AS id, tbl_user.username AS email, tbl_user.Station AS station, tbl_station.Emp_Station AS station_code, tbl_user.Link AS portal FROM tbl_user INNER JOIN tbl_station ON tbl_user.usercode=tbl_station.Emp_ID WHERE usercode='{$id}' LIMIT 1;");
}
?>