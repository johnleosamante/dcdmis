<?php
// includes/database/user.php
function user($id) {
  return query("SELECT usercode AS id, username AS email, Station AS station, Link AS portal FROM tbl_user WHERE usercode='{$id}' LIMIT 1;");
}
?>