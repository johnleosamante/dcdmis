<?php
// includes/database/user.php
function user($id) {
  return query("SELECT tbl_user.usercode AS id, tbl_user.username AS email, tbl_user.Station AS code, tbl_station.Emp_Station AS station_id, tbl_user.Link AS portal FROM tbl_user INNER JOIN tbl_station ON tbl_user.usercode=tbl_station.Emp_ID WHERE usercode='{$id}' LIMIT 1;");
}

function user_role($id, $station) {
  return query("SELECT usercode AS id FROM tbl_user WHERE usercode='{$id}' AND Station='{$station}' LIMIT 1;");
}
?>