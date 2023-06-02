<?php
// includes/database/utility.php
function stationName($id) {
  $section = section($id, true);

  if (numRows($section) > 0) {
    return fetchAssoc($section)['name'];
  }

  $school = schoolByAlias($id);
  return numRows($school) > 0 ? fetchAssoc($school)['name'] : $id;
}

function user_name($id) {
  $users = employee($id);

  if (numRows($users) > 0) {
    $user = fetchAssoc($users);
    return to_name($user['lname'], $user['fname'], $user['mname'], $user['ext'], true);
  }
  
  return $id;
}
?>