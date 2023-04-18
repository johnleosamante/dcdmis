<?php
// includes/database/utility.php

function station_name($id) {
  $section = section($id, true);

  if (num_rows($section) > 0) {
    return fetch_assoc($section)['name'];
  } else {
    $school = school_by_alias($id);
    return num_rows($school) > 0 ? fetch_assoc($school)['name'] : $id;
  }
}

function user_name($id) {
  $user = fetch_assoc(employee($id));

  return to_name($user['lname'], $user['fname'], $user['mname'], $user['ext'], true);
}
?>