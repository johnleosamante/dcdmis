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

function userName($id) {
  $users = employee($id);

  if (numRows($users) > 0) {
    $user = fetchAssoc($users);
    return toName($user['lname'], $user['fname'], $user['mname'], $user['ext'], true);
  }
  
  return $id;
}
?>