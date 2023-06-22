<?php
// includes/database/utility.php
function stationName($id) {
  $station = section($id, true);

  if (numRows($station) > 0) {
    return fetchAssoc($station)['name'];
  }

  $station = schoolByAlias($id);

  if (numRows($station) > 0) {
    return fetchAssoc($station)['name'];
  }

  $station = schoolById($id);

  if (numRows($station) > 0) {
    return fetchAssoc($station)['name'];
  }

  return $id;
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